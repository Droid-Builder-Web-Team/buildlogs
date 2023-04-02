<?php

namespace App\Http\Livewire;

use App\Models\BuildLog;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use Spatie\Tags\Tag;

final class BuildLogTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {


        return [
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\BuildLog>
    */
    public function datasource(): Builder
    {
        return BuildLog::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('title', function (BuildLog $model) {
                return "<a href='".route('buildlogs.show', $model->id)."'>".$model->title."</a>";
            })
            ->addColumn('type', function ( BuildLog $model) {
                $types = "";
                foreach($model->type() as $type)
                {
                    //$types = "<span class='bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300'>";
                    $types .= $type->name; //."</span>";
                }
                return $types;
            })
            ->addColumn('material', function ( BuildLog $model) {
                $materials = "";
                foreach($model->material() as $material)
                {
                    $materials .= $material->name;
                }
                return $materials;
            })
            ->addColumn('user.name')
            ->addColumn('posts', function (BuildLog $model) {
                return $model->num_posts();
            })
            ->addColumn('lastpost', function (BuildLog $model) {
                return $model->last_post();
            })
            ->addColumn('likes', function (BuildLog $model) {
                return $model->likes();
            })
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (BuildLog $model) => Carbon::parse($model->created_at)->format('d/m/Y'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [

            Column::make('Title', 'title')
                ->searchable()
                ->makeInputText('title')
                ->sortable(),

            Column::make('Type', 'type')
                ->searchable()
                ->bodyAttribute('text-xs font-medium mr-2 px-2.5 text-center bg-green-100', 'text-xs')
                ->makeInputMultiSelect(Tag::withType('buildlog')->get(), 'type', 'type')
                ->sortable(),   

            Column::make('Material', 'material')
                ->searchable()
                ->bodyAttribute('text-xs font-medium mr-2 px-2.5 text-center bg-green-100', 'text-xs')
                ->makeInputMultiSelect(Tag::withType('material')->get(), 'material', 'material')
                ->sortable(),   

            Column::make('Builder', 'user.name')
                ->searchable()
                ->makeInputText('user.name')
                ->sortable(),

            Column::add()
                ->title('Posts')
                ->field('posts'),

            Column::add()
                ->title('Last Post')
                ->field('lastpost')
                ->sortable()
                ->makeInputDatePicker(),

            Column::add()
                ->title('Likes')
                ->field('likes')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->makeInputDatePicker()
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid BuildLog Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('build-log.edit', ['build-log' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('build-log.destroy', ['build-log' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid BuildLog Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($build-log) => $build-log->id === 1)
                ->hide(),
        ];
    }
    */
}
