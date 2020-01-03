<?php

namespace App\Contracts;

interface MustVerifyMobile
{

    public function hasMobileNumber();
    /**
     * Determine if the user has verified their mobile number.
     *
     * @return bool
     */
    public function hasVerifiedMobile();

    /**
     * Mark the given user's  mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified();

    /**
     * Send the  mobile verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification();
}
