<?php

use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;

return[
     'additional_column_list' => [
         SectionAdditionalColumn::NUMBER,
         SectionAdditionalColumn::NAME,
         SectionAdditionalColumn::NOTES,
         SectionAdditionalColumn::UPLOADED_BY,
//         SectionAdditionalColumn::CREATED_BY,
         SectionAdditionalColumn::SIGNED_BY,
         SectionAdditionalColumn::CREATION_DATE,
         SectionAdditionalColumn::DUE_DATE,
     ]
];
