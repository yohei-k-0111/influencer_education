<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;//追記
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
        // 'grade_id',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // grade（親）とのリレーション
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    // curriculum_progresses（子）とのリレーション
    public function curriculumProgresses()
    {
        return $this->hasMany(CurriculumProgress::class, 'users_id');
    }
    // class_clear_checks（子）とのリレーション
    public function checks()
    {
        return $this->hasMany(ClassesClearCheck::class);
    }

    public function updateProfile($data) {
        $this->fill($data);

        if (isset($data['password'])) {
            $this->password = bcrypt($data['password']);
        }

        // if (isset($data['profile_image'])) {
        //     $this->profile_image = $data['profile_image'];
        // }
        // 画像ファイルがアップロードされたかどうかをチェック
        // if (isset($data['profile_image']) && $data['profile_image'] instanceof \Illuminate\Http\UploadedFile) {
        //     $file_name = $data['profile_image']->getClientOriginalName();
        //     $data['profile_image']->storeAs('public', $file_name);
        //     $this->profile_image = $file_name;
        // }
        if (isset($data['profile_image'])) {
            // 一時ディレクトリから適切な場所に画像を移動
            $tempPath = 'temp/' . $data['profile_image'];
            $newFileName = 'profile_' . time() . '_' . $this->id . '.' . pathinfo($data['profile_image'], PATHINFO_EXTENSION);
            $newPath = 'profile_images/' . $newFileName;
    
            if (Storage::disk('public')->exists($tempPath)) {
                Storage::disk('public')->move($tempPath, $newPath);
                
                // 古いプロフィール画像を削除（存在する場合）
                if ($this->profile_image && $this->profile_image !== 'noimage.jpeg') {
                    Storage::disk('public')->delete('profile_images/' . $this->profile_image);
                }
    
                $this->profile_image = $newFileName;
            }
        }


        $this->save();
    }
}
