<?php
namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request)
    {
        // Get the 'tag' parameter from the request, or an empty array if it doesn't exist
        $filters = $request->only(['tag','search']); // This returns an array with 'tag' if it exists, or an empty array

        $listings = Listing::latest()
            ->filter($filters) // Pass the filters array to the scopeFilter method
            ->paginate(4);

        return view('listings.index', [
            'listings' => $listings
        ]);
    }

    // Show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
            //show create form
            public function create(){
                return view('listings.create');

            } 
            //store Listing data .
            public function store(Request $request){
                $formField = $request->validate([
                    'title'   => 'required',
                    'company' => ['required', Rule::unique('listings','company')],
                    'location' => 'required',
                    'website'  => 'required',
                    'email' => ['required','email'],
                    'tags' =>'required',
                    'description' => 'required'



                ]);
                        if($request->hasFile('logo')){
                            $formField['logo'] = $request->file('logo')->store('logos','public');

                        }
                            $formField['user_id']= auth()->id();





                Listing::create($formField);
                return redirect('/listings')->with('message' ,  'Job created successfully!');



            }
            // show edit form 


            public function edit(Listing $listing){
                return view('listings.edit',['listing'=> $listing]);




            }

                //Update Listing data
            public function update(Request $request, Listing $listing){
                 // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

                $formField = $request->validate([
                    'title'   => 'required',
                    'company' => 'required',
                    'location' => 'required',
                    'website'  => 'required',
                    'email' => ['required','email'],
                    'tags' =>'required',
                    'description' => 'required'

                ]);

                if($request->hasFile('logo')){
                    $formField['logo'] = $request->file('logo')->store('logos','public');



                }                
                $listing->update($formField);
                return back()->with('message' ,  'Job updated successfully!');  
            }
                
//delete a list 
public function destroy (Listing $listing){
    $listing->delete();
    return redirect('/listings')->with('message', 'Listing deleted successfully');

}           
 // Manage Listings
 public function manage() {
    return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
}
}

