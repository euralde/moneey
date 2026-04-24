<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Exemple de relation : Un département peut avoir plusieurs employés.
     * (À décommenter ou adapter selon tes besoins futurs)
     */
    /*
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    */
}