<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AssetRequest as StoreRequest;
use App\Http\Requests\AssetRequest as UpdateRequest;

class AssetCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Asset');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/asset');
        $this->crud->setEntityNameStrings('asset', 'assets');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

//        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        $this->crud->addField([
            'name' => 'barcode_no',
            'label' => 'Barcode Number',
            'type'  => 'text',
            'attributes' => [
//                'readonly' => 'readonly'
            ]
        ]);

        $this->crud->addField([
            'name' => 'asset_name',
            'label' => 'Asset Name',
            'type'  => 'text'
        ]);

        $this->crud->addField([
            'name' => 'category_id',
            'label' => 'Category',
            'type'  => 'select2',
            'entity' => 'category',
            'attribute' => 'category_name',
            'model' => "App\Models\Category"
        ]);

        $this->crud->addField([
            'name' => 'brand_id',
            'label' => 'Brand',
            'type'  => 'select2',
            'entity' => 'brand',
            'attribute' => 'brand_name',
            'model' => "App\Models\Brand"
        ]);

        $this->crud->addField([
            'name' => 'asset_description',
            'label' => 'Asset Description',
            'type'  => 'textarea'
        ]);

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        $this->crud->addColumn([
            'name' => 'asset_name', // The db column name
            'label' => "Asset Name", // Table column heading
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'user_id', // The db column name
            'label' => "Currently Assign To", // Table column heading
            'type' => 'select',
            'entity' => 'user', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\User", // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'barcode_no', // The db column name
            'label' => "Barcode Number", // Table column heading
            'type' => 'text'
        ]);

//        $this->crud->addColumn([
//            'name' => 'imei_no', // The db column name
//            'label' => "IMEI Number", // Table column heading
//            'type' => 'text'
//        ]);
//
//        $this->crud->addColumn([
//            'name' => 'serial_no', // The db column name
//            'label' => "Serial Number", // Table column heading
//            'type' => 'text'
//        ]);

        $this->crud->addColumn([
            'name' => 'category_id', // The db column name
            'label' => "Category", // Table column heading
            'type' => 'select',
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => "category_name", // foreign key attribute that is shown to user
            'model' => "App\Models\Category", // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'brand_id', // The db column name
            'label' => "Brand", // Table column heading
            'type' => 'select',
            'entity' => 'brand', // the method that defines the relationship in your Model
            'attribute' => "brand_name", // foreign key attribute that is shown to user
            'model' => "App\Models\Brand", // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'audit_trail', // The db column name
            'label' => "Audit Trail", // Table column heading
            'type' => 'url'
        ]);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);

//        $this->crud->addButton('line ', 'test', 'view', 'test', 'beginning');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
         $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
