<?php

namespace Webkul\Dropship\DataGrids\Admin;

use DB;
use Webkul\Ui\DataGrid\DataGrid;

/**
 * Product Data Grid class
 *
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductDataGrid extends DataGrid
{
    /**
     *
     * @var integer
     */
    public $index = 'product_id';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('product_flat')
                ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                ->join('dropship_ali_express_products', 'product_flat.product_id', '=', 'dropship_ali_express_products.product_id')
                ->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id')

                ->addSelect('dropship_ali_express_products.id as dropship_ali_express_product_id', 'product_flat.product_id', 'product_flat.sku', 'product_flat.name', 'product_flat.price', 'product_inventories.qty as quantity')->orderBy('product_id','desc');

        $this->addFilter('sku', 'product_flat.sku');
        $this->addFilter('product_id', 'product_flat.product_id');
        $this->addFilter('price', 'product_flat.price');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'product_id',
            'label' => trans('dropship::app.admin.products.product-id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'sku',
            'label' => trans('dropship::app.admin.products.sku'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('dropship::app.admin.products.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'price',
            'label' => trans('dropship::app.admin.products.price'),
            'type' => 'price',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => trans('dropship::app.admin.products.quantity'),
            'type' => 'number',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.catalog.products.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'admin.catalog.products.delete',
            // 'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'icon trash-icon'
        ]);
    }
}