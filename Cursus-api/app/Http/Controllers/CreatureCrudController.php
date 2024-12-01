<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminCreatureRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CreatureCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CreatureCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Creature::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/creature');
        CRUD::setEntityNameStrings('creature', 'creatures');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column([
            'name' => 'name',
            'label' => "Nom",
            'type' => 'text'
        ]);

        CRUD::column([
            'name' => 'avatar',
            'label' => "Avatar",
            'type' => 'image'
        ])->withFiles([
            'disk' => 'public', // the disk where file will be stored
            'path' => 'uploads', // the path inside the disk where file will be stored
        ]);

        CRUD::column([
            'name' => 'type',
            'label' => "Type",
            'type' => 'enum'
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AdminCreatureRequest::class);

        CRUD::field([
            'name' => 'name',
            'label' => 'Nom',
            'type' => 'text',
        ]);

        CRUD::field([
            'name' => 'pv',
            'label' => 'Point de vie',
            'type' => 'number',
        ]);

        CRUD::field([
            'name' => 'atk',
            'label' => 'Attaque',
            'type' => 'number',
        ]);

        CRUD::field([
            'name' => 'def',
            'label' => 'Defense',
            'type' => 'number',
        ]);

        CRUD::field([
            'name' => 'speed',
            'label' => 'Vitesse',
            'type' => 'number',
        ]);

        CRUD::field([
            'name' => 'capture_rate',
            'label' => 'Taux de captures',
            'type' => 'number',
        ]);

        CRUD::field([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'enum',
        ]);

        CRUD::field([
            'name' => 'race',
            'label' => 'Race',
            'type' => 'enum',
        ]);

        CRUD::field([
            'name' => 'avatar',
            'label' => 'Avatar',
            'type' => 'upload',
        ])->withFiles([
            'disk' => 'public', // the disk where file will be stored
            'path' => 'uploads/images', // the path inside the disk where file will be stored
        ]);

        CRUD::field([
            'name' => 'user_id',
            'label' => 'Dresseur'
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
