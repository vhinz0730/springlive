<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MultiTenantModelTrait
{
    public static function bootMultiTenantModelTrait()
    {
       
           
            
            
                static::addGlobalScope('team_id', function (Builder $builder) {
                    $field = sprintf('%s.%s', $builder->getQuery()->from, 'team_id');

                    $builder->where($field, auth()->user()->team_id)->orWhereNull($field);
                });
            
        
    }
}
