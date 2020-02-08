<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 
        'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query,$order)
    {
        //不同的排序，使用不同的数据读取逻辑
        switch($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at','desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }

}
