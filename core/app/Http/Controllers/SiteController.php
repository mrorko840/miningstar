<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Miner;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $data_page = 'index';
        $reference = @$_GET['ref'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();
        $miners     = Miner::with('activePlans')->whereHas('activePlans')->get();
        $plans      = Plan::where('status', 1)->get();
        
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'miners', 'plans', 'data_page'));
    }

    public function style()
    {
        $pageTitle = 'Style';
        $data_page = 'style';
        
        return view($this->activeTemplate . 'style', compact('pageTitle', 'data_page'));

    }
 
    public function statistics()
    {
        $pageTitle = 'Statistics';
        $data_page = 'stats';
        $miners     = Miner::with('activePlans')->whereHas('activePlans')->get();
        $plans      = Plan::get();
        
        return view($this->activeTemplate . 'statistics', compact('pageTitle', 'data_page', 'miners', 'plans'));

    }

    public function notify()
    {
        $pageTitle = 'Notifications';
        $data_page = 'blank';
        
        return view($this->activeTemplate . 'notification.index', compact('pageTitle', 'data_page'));

    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $miners     = Miner::with('activePlans')->whereHas('activePlans')->get();
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections', 'miners'));
    }

    public function plans()
    {
        $pageTitle = 'Plans';
        $sections   = Page::where('tempname', $this->activeTemplate)->where('slug', 'plans')->first();
        $miners     = Miner::with('activePlans')->whereHas('activePlans')->get();
        return view($this->activeTemplate . 'plans', compact('pageTitle', 'sections', 'miners'));
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $sections   = Page::where('tempname', $this->activeTemplate)->where('slug', 'blogs')->first();
        $blogs      = Frontend::activeTemplate()->where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(9);
        return view($this->activeTemplate . 'blogs', compact('pageTitle', 'sections', 'blogs'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'sections'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = now();
        $ticket->status =  Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::activeTemplate()->where('data_keys', 'policy_pages.element')->findOrFail($id);
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug, $id)
    {
        $blog            = Frontend::activeTemplate()->where('data_keys', 'blog.element')->findOrFail($id);
        $pageTitle       = 'Blog Details';
        $customPageTitle = $blog->data_values->title;
        $latestBlogs     = Frontend::activeTemplate()->where('id', '!=', $id)->where('data_keys', 'blog.element')->take(5)->get();
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latestBlogs', 'customPageTitle'));
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/RobotoMono-Regular.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general = gs();
        if ($general->maintenance_mode == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view($this->activeTemplate . 'maintenance', compact('pageTitle', 'maintenance'));
    }

    public function addSubscriber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid Email.']);
        }

        $exist = Subscriber::where('email', $request->email)->first();
        if (!$exist) {
            $subscribe = new Subscriber();
            $subscribe->email = $request->email;
            $subscribe->save();

            return response()->json(['success' => 'Subscribed Successfully']);
        } else {
            return response()->json(['error' => 'Already Subscribed']);
        }
    }
}
