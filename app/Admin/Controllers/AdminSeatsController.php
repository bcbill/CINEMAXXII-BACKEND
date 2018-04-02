<?php

namespace App\Admin\Controllers;

use App\Seats;
use App\Time;
use App\Ticket;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AdminSeatsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        //dd(Seats::all());
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Seats::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->columns('position','time_id','taken');
            
    
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Seats::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('position');
            $form->select('time_id')->options(Time::all()->pluck('time', 'id')); //movie name yang keluar

            
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

}