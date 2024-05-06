<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'projects';

    public static $searchable = [
        'project_name',
    ];


    protected $dates = [
        'signup_date',
        'webdev_deadline',
        'webdev_launchdate',
        'webdev_renewaldate',
        'seo_deadline',
        'seo_launch_date',
        'seo_renewaldate',
        'seo_report',
        'smm_deadline',
        'smm_launchdate',
        'smm_renewaldate',
        'smm_report',
        'vid_deadline',
        'vid_launchdate',
        'graphics_deadline',
        'graphics_launchdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        
        //general
            'id',
            'project_name',
            'agent_id',
            'industry_id',
            'project_cost',
            'payment',
            'paid',
            'status',
            'signup_date',
        //webdev
            'url',
            'webdev_type', 
            'webdev_status', 
            'staging',
            'wp_login',
            'password',
            'webdev_deadline',
            'webdev_launchdate',
            'webdev_renewaldate',
            'webdev_cost',
            'design_checklist',
            'staging_checklist',
            'host_domain_information',
        //seo
            'seo_status',
            'seo_cost',
            'seo_deadline',
            'seo_launch_date',
            'seo_renewaldate',
        //smm
            'smm_status',
            'smm_report',
            'social_media_email',
            'sim_card_number',
            'smm_deadline',
            'smm_launchdate',
            'smm_renewaldate',
            'smm_cost',
            'social_media_links',
        //vid
            'vid_status',
            'vid_cost',
            'vid_launchdate',
            'vid_deadline',
        //graphics
            'graphics_status',
            'graphic_cost',
            'graphics_launchdate',
            'graphics_deadline',
        //client
            'clients_info',
        //services
            'webdev',
            'seo',
            'smm',
            'vid',
            'graphic',
        // team id
            'team_id',
        //total cost - balance
            'total_cost',
            'balance',
        //automatics
            'created_at',
            'updated_at',
            'deleted_at',
            
           
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function projectLayouts()
    {
        return $this->hasMany(Layout::class, 'project_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    public function payment()
    {
        return $this->hasMany(Payment::class, 'payment_id');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
   
}
