<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class Account extends Model
{
    use HasFactory, HasRoles;

   protected $fillable = [
        'UserId',
        'CompanyId',
        'JobTitle',
   ];

	protected $primaryKey = 'Id';
	public $incrementing = true;
	protected $keyType = 'int';
    protected $guard_name = 'web';

	public function getMorphClass(): string
	{
		return 'App\Models\Account';
	}

	public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'UserId');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class, 'CompanyId');
    }
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

	public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
	{
		return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
			->wherePivot('model_type', $this->getMorphClass());

	}
}
