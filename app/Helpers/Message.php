<?php

namespace App\Helpers;

class Message
{
    const NO_DATA_TO_EXPORT = 'There is no data to be exported!';

    const MUST_RETURN_AN_ARRAY = 'jsonSerialize must return an array';

    const MUST_IMPLEMENT_JSON_SERIALIZE = 'Resource must implement JsonSerializable';

    const PAYROLL_CREATED = 'Payroll Created Successfully';

    const PAYROLL_PENDING_FOR_APPROVAL = 'Payroll Pending For Approval';

    const PAYROLL_APPROVED_SUCCESSFULLY = 'Payroll Approved Successfully';
}
