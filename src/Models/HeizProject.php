<?php
/*
 * HeizProject.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi\Models;

use Illuminate\Database\Eloquent\Model;

class HeizProject extends Model
{
    protected $fillable = [
        'projektKey',
        'projektData'
    ];

    protected $casts = [
        'projektData' => 'array',  // Die `projektData` wird als Array behandelt
    ];
}
