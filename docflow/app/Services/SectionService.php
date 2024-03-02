<?php

namespace App\Services;

use App\Models\section\Section;

class SectionService
{
    public function grantPermission(Section $section, $permission)
    {
        // Logic to grant a permission to a section
    }

    public function revokePermission(Section $section, $permission)
    {
        // Logic to revoke a permission from a section
    }

    public function checkPermission(Section $section, $permission)
    {
        // Logic to check if a section has a permission
    }
}
