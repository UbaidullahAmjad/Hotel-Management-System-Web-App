<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookNowSetting;
use App\Models\Confirmation;
use App\Models\HeaderFooter;
use App\Models\HomePageSetting;
use App\Models\NewHomeSetting;
use App\Models\LoginRegisterPage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }


    public function homePageForm(){

        $settings = HomePageSetting::all();
        $setting = $settings[0];
        return view('admin.cms.homepage',[
            'setting' => $setting
        ]);
    }

    public function homePageUpdate(Request $request,$id){

        $setting = HomePageSetting::find($id);

        $setting->adult = $request->adults;
        $setting->child1 = $request->child1;
        $setting->child2 = $request->child2;
        $setting->s_btn = $request->search_btn_text;
        $setting->search_result = $request->search_res_text;
        $setting->invoice = $request->invoice;
        $setting->datefrom = $request->datefrom;
        $setting->dateto = $request->dateto;
        $setting->n_days = $request->n_days;
        $setting->n_beds = $request->n_beds;
        $setting->c_pack = $request->c_pack;
        $setting->total = $request->total;
        $setting->ppn = $request->ppn;
        $setting->etax = $request->etax;

        $setting->adult1 = $request->adults1;
        $setting->child11 = $request->child11;
        $setting->child22= $request->child22;
        $setting->s_btn1 = $request->search_btn_text1;
        $setting->search_result1 = $request->search_res_text1;
        $setting->invoice1 = $request->invoice1;
        $setting->datefrom1 = $request->datefrom1;
        $setting->dateto1 = $request->dateto1;
        $setting->n_days1 = $request->n_days1;
        $setting->n_beds1 = $request->n_beds1;
        $setting->c_pack1 = $request->c_pack1;
        $setting->total1 = $request->total1;
        $setting->ppn1 = $request->ppn1;
        $setting->etax1 = $request->etax1;

        $setting->save();

        return redirect()->route('setting.home')->with('success','Settings Updated');

    }

    public function bookPageForm(){

        $settings = BookNowSetting::all();
        $setting = $settings[0];
        return view('admin.cms.booknow',[
            'setting' => $setting
        ]);
    }


    public function bookPageUpdate(Request $request,$id){

        $setting = BookNowSetting::find($id);

        $setting->s_service = $request->service;
        $setting->s_name = $request->name;
        $setting->s_des = $request->desc;
        $setting->s_price = $request->price;
        $setting->s_avail = $request->avail;
        $setting->order_sum = $request->o_sum;
        $setting->coupon = $request->coupon;
        $setting->a_coupon = $request->a_coupon;
        $setting->d_coupon = $request->d_coupon;
        $setting->c_info = $request->c_info;
        $setting->f_name = $request->f_name;
        $setting->l_name = $request->l_name;
        $setting->mob = $request->mob;
        $setting->email = $request->email;
        $setting->s_req = $request->s_req;
        $setting->c_p_method = $request->pm;
        $setting->in_person = $request->in;
        $setting->bt = $request->bt;
        $setting->cc = $request->cc;
        $setting->term = $request->term;
        $setting->policy = $request->policy;
        $setting->c_book = $request->c_b;
        $setting->c_policy = $request->c_p;

        $setting->o_number = $request->o_n;
        $setting->o_price = $request->o_p;
        $setting->d_range = $request->d_r;
        $setting->to = $request->to;



        $setting->s_service1 = $request->service1;
        $setting->s_name1 = $request->name1;
        $setting->s_des1 = $request->desc1;
        $setting->s_price1 = $request->price1;
        $setting->s_avail1 = $request->avail1;
        $setting->order_sum1 = $request->o_sum1;
        $setting->coupon1 = $request->coupon1;
        $setting->a_coupon1 = $request->a_coupon1;
        $setting->d_coupon1 = $request->d_coupon1;
        $setting->c_info1 = $request->c_info1;
        $setting->f_name1 = $request->f_name1;
        $setting->l_name1 = $request->l_name1;
        $setting->mob1 = $request->mob1;
        $setting->email1 = $request->email1;
        $setting->s_req1 = $request->s_req1;
        $setting->c_p_method1 = $request->pm1;
        $setting->in_person1 = $request->in1;
        $setting->bt1 = $request->bt1;
        $setting->cc1 = $request->cc1;
        $setting->term1 = $request->term1;
        $setting->policy1 = $request->policy1;
        $setting->c_book1 = $request->c_b1;
        $setting->c_policy1 = $request->c_p1;

        $setting->o_number1 = $request->o_n1;
        $setting->o_price1 = $request->o_p1;
        $setting->d_range1 = $request->d_r1;
        $setting->to1 = $request->to1;
        $setting->save();


        return redirect()->route('setting.booknow')->with('success','Settings Updated');

    }
    public function confirmPageForm(){

        $settings = Confirmation::all();
        $setting = $settings[0];
        return view('admin.cms.confirmation',[
            'setting' => $setting
        ]);
    }

    public function confirmPageUpdate(Request $request,$id){

        $setting = Confirmation::find($id);

        $setting->update($request->only($setting->getFillable()));

        return redirect()->route('setting.confirm')->with('success','Settings Updated');

    }


    public function headerPageForm(){

        $settings = HeaderFooter::all();
        $setting = $settings[0];
        return view('admin.cms.headerfooter',[
            'setting' => $setting
        ]);
    }

    public function headerPageUpdate(Request $request,$id){

        $setting = HeaderFooter::find($id);

        $set = $setting->update($request->only($setting->getFillable()));


        if (!empty($request->logo)) {
            $image = $request->logo;

            $name = $image->getClientOriginalName();

            $fileName = time() . $name;
            $image->move(storage_path() . '/app/public/', $fileName);

            $setting->logo = $fileName;
            $setting->save();
        }

        return redirect()->route('setting.header')->with('success','Settings Updated');

    }


    public function logregPageForm(){

        $settings = LoginRegisterPage::all();
        $setting = $settings[0];
        return view('admin.cms.logreg',[
            'setting' => $setting
        ]);
    }

    public function logregPageUpdate(Request $request,$id){

        $setting = LoginRegisterPage::find($id);

        $set = $setting->update($request->only($setting->getFillable()));




        return redirect()->route('setting.logreg')->with('success','Settings Updated');

    }
    
    
    
    // new code
    
    public function newHomePageForm(){

        $setting = NewHomeSetting::first();
        
        return view('admin.cms.newhomesetting',[
            'setting' => $setting
        ]);
    }

    public function newhomePageUpdate(Request $request,$id){

        // dd($request->all());
        $setting = NewHomeSetting::find($id);

        if (!empty($request->logo)) {
            $image = $request->logo;

            $name = $image->getClientOriginalName();

            $fileName = time() . $name;
            $image->move(storage_path() . '/app/public/', $fileName);

            $setting->logo = $fileName;
            
        }
        
        if (!empty($request->back)) {
            $image = $request->back;

            $name = $image->getClientOriginalName();

            $fileName = time() . $name;
            $image->move(storage_path() . '/app/public/', $fileName);

            $setting->back = $fileName;
            
        }

        if (!empty($request->address)) {
            $setting->address = $request->address;
        }
        
        if (!empty($request->address1)) {
            $setting->address1 = $request->address1;
        }
        
        if (!empty($request->btncolor)) {
            $setting->btncolor = $request->btncolor;
        }
        
        if (!empty($request->btncolor1)) {
            $setting->btncolor1 = $request->btncolor1;
        }
       
        $setting->save();
        return redirect()->route('setting.newhome')->with('success','Settings Updated');

    }
}
