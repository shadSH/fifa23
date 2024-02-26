<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactUsSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function index()
    {
        $today_mails = Contact::whereDate('created_at', Carbon::today())->count();
        $inbox = Contact::where('read', 0)->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.index', compact('inbox', 'starred', 'today_mails'));
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::whereNull('deleted_at')->get();

            return Datatables::of($contacts)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })->editColumn('message', function ($data) {
                    return Str::limit($data->message, 15);
                })->editColumn('avatar', function ($data) {
                    return '<img src="'.Avatar::create($data->full_name)->toBase64().'" style="width: 50px; height:50px">';
                })->editColumn('starred', function ($data) {
                    if ($data->starred == 1) {
                        $class = 'icon-star-full2 text-warning';
                    } else {
                        $class = 'icon-star-empty3 text-muted';
                    }

                    $checkbox = '<label class="custom-control custom-control-success custom-checkbox mb-2">
													<input type="checkbox" class="custom-control-input checkbox_change_status" data-route="'.route('contact_us.starred', [$data->id]).'">
													<i class="'.$class.'"></i>
												</label>';

                    return $checkbox;
                })->setRowClass(function ($data) {
                    return $data->read == 0 ? 'unread' : 'read';
                })->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->addIndexColumn()
                ->rawColumns(['active', 'checkbox', 'starred', 'avatar'])
                ->make(true);
        }
    }

    public function starred(Contact $contact)
    {
        if ($contact->starred == 1) {
            $contact->starred = 0;
        } else {
            $contact->starred = 1;
        }
        $contact->save();

        return response()->json([
            'status' => true,
            'message' => 'Changed successfully!',
        ]);
    }

    public function write(Contact $contact)
    {
        $inbox = Contact::where('read', 0)->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.read', compact('inbox', 'starred'));
    }

    public function read(Contact $contact)
    {
        $inbox = Contact::where('read', 0)->whereNull('deleted_at')->count();
        $starred = Contact::where('starred', 1)->count();
        $contact->read = 1;
        $contact->save();

        return view('contact_us.read', compact('inbox', 'starred', 'contact'));
    }

    public function read_history(ContactUsSent $contact)
    {
        $inbox = Contact::where('read', 0)->whereNull('deleted_at')->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.read_history', compact('inbox', 'starred', 'contact'));
    }

    public function send_mail(Request $request)
    {
        $validatedData = $request->validate([
            'to' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
        ]);
        $contacts_sent = save_mail('mail@khoshnaw.com', $request->to, $request->subject, $request->message);
        //adding real mail sender here before production
        if ($contacts_sent) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email sent Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email sent failed',
            ]);
        }
    }

    public function sent_mails()
    {
        $inbox = Contact::where('read', 0)->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.sent_mail', compact('inbox', 'starred'));
    }

    public function data_sent(Request $request)
    {
        if ($request->ajax()) {
            $contacts = ContactUsSent::all();

            return Datatables::of($contacts)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })->editColumn('message', function ($data) {
                    return Str::limit($data->message, 15);
                })->editColumn('avatar', function ($data) {
                    return '<img src="'.Avatar::create($data->to)->toBase64().'" style="width: 50px; height:50px">';
                })->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->addIndexColumn()
                ->rawColumns(['avatar', 'message'])
                ->make(true);
        }
    }

    public function starred_mails()
    {
        $inbox = Contact::where('read', 0)->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.starred', compact('inbox', 'starred'));
    }

    public function data_starred(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::where('starred', 1)->whereNull('deleted_at')->get();

            return Datatables::of($contacts)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })->editColumn('message', function ($data) {
                    return Str::limit($data->message, 15);
                })->editColumn('avatar', function ($data) {
                    return '<img src="'.Avatar::create($data->full_name)->toBase64().'" style="width: 50px; height:50px">';
                })->editColumn('starred', function ($data) {
                    if ($data->starred == 1) {
                        $class = 'icon-star-full2 text-warning';
                    } else {
                        $class = 'icon-star-empty3 text-muted';
                    }

                    $checkbox = '<label class="custom-control custom-control-success custom-checkbox mb-2">
													<input type="checkbox" class="custom-control-input checkbox_change_status" data-route="'.route('contact_us.starred', [$data->id]).'">
													<i class="'.$class.'"></i>
												</label>';

                    return $checkbox;
                })->setRowClass(function ($data) {
                    return $data->read == 0 ? 'unread' : 'read';
                })->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->addIndexColumn()
                ->rawColumns(['active', 'checkbox', 'starred', 'avatar'])
                ->make(true);
        }
    }

    public function trashed_mails()
    {
        $inbox = Contact::where('read', 0)->count();
        $starred = Contact::where('starred', 1)->count();

        return view('contact_us.trashed', compact('inbox', 'starred'));
    }

    public function data_trashed(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::onlyTrashed();

            return Datatables::of($contacts)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })->editColumn('message', function ($data) {
                    return Str::limit($data->message, 15);
                })->addColumn('avatar', function ($data) {
                    return '<img src="'.Avatar::create($data->full_name)->toBase64().'" style="width: 50px; height:50px">';
                })->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ])
                ->addIndexColumn()
                ->rawColumns(['active', 'checkbox', 'avatar'])
                ->make(true);
        }
    }

    public function reply(Contact $contact)
    {
        return response()->json([
            'status' => true,
            'html' => ''.view_template_part('contact_us.reply', compact('contact')).'',
            'data' => $contact,
        ]);
    }

    public function destroy(Contact $contact_u)
    {

        if ($contact_u->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Record deleted successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Record Not deleted!',
            ]);
        }

    }
}
