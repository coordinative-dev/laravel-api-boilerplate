<?php

namespace App\Modules\API\Definitions;

/**
 * @SWG\Definition(required={"name", "email"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="name", type="string", maxLength=255)
 * @SWG\Property(property="email", type="string", maxLength=255)
 * @SWG\Property(property="image", type="string")
 * @SWG\Property(property="created_at", type="string")
 */
class User
{
}
