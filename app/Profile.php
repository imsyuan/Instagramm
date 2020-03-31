<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded =[];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'profile/yrcuRnU8qT9gyTj3z059XQFBHQAoMdrnrXoxNVe3.png';
        return '/storage/' . $imagePath;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
