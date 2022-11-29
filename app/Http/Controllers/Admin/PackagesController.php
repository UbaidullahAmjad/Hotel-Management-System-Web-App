<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\BadgePackage;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageService;
use App\Models\Service;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();

        return view('admin.packages.index', [
            'packages' => $packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $badges = Badge::all();
        return view('admin.packages.create', [
            'services' => $services,
            'badges' => $badges,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $services = $request->services;
        $badges = $request->badges;
        $package = new Package();

        $packageCreated = $package->create($request->only($package->getFillable()));
        if (!empty($services)) {
            for ($i = 0; $i < count($services); $i++) {
                $service = Service::find($services[$i]);
                // $packageCreated->packagesServices->attach($service->id);
                $package_service = new PackageService();
                $package_service->package_id = $packageCreated->id;
                $package_service->service_id = $service->id;
                $package_service->save();
            }
        }

        if (!empty($badges)) {
            for ($i = 0; $i < count($badges); $i++) {

                $badge_package = new BadgePackage();
                $badge_package->package_id = $packageCreated->id;
                $badge_package->badge_id = $badges[$i];
                $badge_package->save();
            }
        }





        return redirect()->route('packages.index')->with('success', 'Package Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $package = Package::find($id);

        return view('admin.packages.show', [
            'package' => $package
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Service::all();
        $package = Package::find($id);
        $selectedbadges = Badge::join('badge_packages', 'badge_packages.badge_id', 'badges.id')
            ->where('badge_packages.package_id', $id)->get();

        // dd($selectedbadges);
        $badges = Badge::all();

        return view('admin.packages.edit', [
            'package' => $package,
            'services' => $services,
            'selectedbadges' => $selectedbadges,
            'badges' => $badges,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        $packageUpdated = $package->update($request->only($package->getFillable()));
        // dd($packageUpdated);
        $services = $request->services;
        $service_ids = array();
        $package_services = PackageService::where('package_id', $id)->get();
        foreach ($package_services as $package_service) {
            array_push($service_ids, $package_service->service_id);
        }
        if (!empty($services)) {
            for ($i = 0; $i < count($services); $i++) {
                $service = Service::find($services[$i]);


                if (!in_array($service->id, $service_ids)) {

                    $package_service1 = new PackageService();
                    $package_service1->package_id = $id;
                    $package_service1->service_id = $service->id;
                    $package_service1->save();
                }
            }
        }

        $badges = $request->badges;


        if (!empty($badges)) {
            for ($i = 0; $i < count($badges); $i++) {

                $badge_package = BadgePackage::where('package_id', $package->id)
                    ->where('badge_id', $badges[$i])->first();
                if (empty($badge_package)) {
                    $badge_package = new BadgePackage();
                    $badge_package->package_id = $package->id;
                    $badge_package->badge_id = $badges[$i];
                    $badge_package->save();
                }
            }
        }

        return redirect()->route('packages.index')->with('success', 'Package Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        PackageService::where('package_id', $id)->delete();
        BadgePackage::where('package_id', $id)->delete();

        $package = Package::find($id);
        // dd($package);
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package Deleted Successfully');
    }


    public function removeService(Request $request)
    {
        // dd($request->all());

        $package_service = PackageService::where('service_id', $request->serv_id)->where('package_id', $request->pack_id)->delete();
        $response = array(
            'status' => 'success',
            'msg'    => 'success',

        );

        return json_encode($response);
    }
}
