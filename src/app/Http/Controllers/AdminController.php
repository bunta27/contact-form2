<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $req)
    {
        [$query, $categories] = $this->buildQuery($req);

        $contacts = $query->with('category')
            ->latest('id')
            ->paginate(7)
            ->withQueryString();

        return view('auth.admin', compact('contacts', 'categories'));
    }
    public function show(Contact $contact)
    {
        return response()->json([
            'id'       => $contact->id,
            'name'     => $contact->name,
            'gender'   => $contact->gender_label ?? $contact->gender,
            'email'    => $contact->email,
            'tel'      => $contact->tel,
            'address'  => $contact->address,
            'building' => $contact->building,
            'type'     => optional($contact->category)->name,
            'detail'  => $contact->detail,
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back();
    }

    public function export(Request $req): StreamedResponse
    {
        [$query] = $this->buildQuery($req);

        $filename = 'contacts_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['お名前','性別','メール','電話','住所','建物名','種類','内容']);

            $query->with('category')->orderBy('id')->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $c) {
                    fputcsv($out, [
                        $c->name,
                        $c->gender_label ?? $c->gender,
                        $c->email,
                        $c->tel,
                        $c->address,
                        $c->building,
                        optional($c->category)->name,
                        $c->detail,
                        optional($c->created_at)->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function buildQuery(Request $req): array
    {
        $q        = trim((string) $req->input('q', ''));
        $gender   = $req->input('gender');
        $category = $req->input('category_id');
        $date     = $req->input('date');


        $query = Contact::query();


        if ($q !== '') {
            $like = '%'.$q.'%';
            $query->where(function ($w) use ($q, $like) {

                    $parts = preg_split('/\s+/u', $q, -1, PREG_SPLIT_NO_EMPTY);
                    if (count($parts) >= 2) {

                        $w->orWhere(function ($ww) use ($parts) {
                            foreach ($parts as $p) {
                                $ww->where('name', 'like', '%'.$p.'%');
                            }
                        });
                    } else {
                        $w->orWhere('name', 'like', $like);
                    }

                    $w->orWhere('email', 'like', $like);
                });
        }


        if (($gender = $req->input('gender')) !== null && $gender !== '') {
        $dbValue = ['male'=>'男性','female'=>'女性','other'=>'その他'][$gender] ?? $gender;
        $query->where('gender', $dbValue);
        }


        if ($category !== null && $category !== '') {
            $query->where('category_id', $category);
        }


        if ($date) $query->whereDate('created_at', $date);

        $categories = Category::orderBy('id')->get();

        return [$query, $categories];
    }
}
