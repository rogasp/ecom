<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Support\Carbon;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('All Orders')),
            'pending' => Tab::make(__('Pending'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::PENDING);
                }),
            'processing' => Tab::make(__('Processing'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::PROCESSING);
                }),
            'shipped' => Tab::make(__('Shipped'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::SHIPPED);
                }),
            'delivered' => Tab::make(__('Delivered'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::DELIVERED);
                }),
            'cancelled' => Tab::make(__('Cancelled'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::CANCELLED);
                }),
            'refunded' => Tab::make(__('Cancelled'))
                ->modifyQueryUsing(function ($query){
                    return $query->where('status', OrderStatus::REFUNDED);
                }),
            ];
    }
}
