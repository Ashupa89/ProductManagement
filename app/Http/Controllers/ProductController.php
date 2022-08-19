<?php namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['products'] = Product::orderBy('id', 'desc')->paginate(5);
        return view('products.products-list', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('products.create-products');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate(['name' => 'required', 'price' => 'required', 'upc' => 'required']);
        $filename = "";
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time() . $uploadedFile->getClientOriginalName();
            $uploadedFile->move('files', $filename);
        }
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->UPC = $request->upc;
        $product->status = $request->status;
        $product->image = $filename;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product has been created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\company  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return view('products.show', compact('product'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        return view('products.edit-product', compact('product'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $request->validate(['name' => 'required', 'price' => 'required', 'upc' => 'required']);
        $product = Product::find($id);
        $filename = "";
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time() . $uploadedFile->getClientOriginalName();
            $uploadedFile->move('files', $filename);
            $product->image = $filename;
        }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->UPC = $request->upc;
        $product->status = $request->status;
        $product->save();
        return redirect()->route('products.index')->with('success', 'product Has Been updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'product has been deleted successfully');
    }

    public function deleteMultiple(Request $request) {
        $request->validate(['id' => 'required', ], ['id.required' => 'Select At lest One Product']);
        $product = Product::whereIn('id', $request->id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'product has been deleted successfully');
    }
}
