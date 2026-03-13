<?php
namespace App\Services;

class ValidationService
{
    /**
     * Validate Philippine phone number (09XX format or +639XX format)
     */
    public static function validatePhoneNumber(string $phone): bool
    {
        // Remove all non-numeric characters except +
        $cleaned = preg_replace('/[^\d+]/', '', $phone);
        
        // Check if valid PH format
        // 09XX-XXX-XXXX or 639XXXXXXXXX
        if (preg_match('/^(09\d{9}|639\d{9}|\+639\d{9})$/', $cleaned)) {
            return true;
        }
        
        return false;
    }

    /**
     * Format Philippine phone number to standard format
     * Returns in format: 639XXXXXXXXX
     */
    public static function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters except +
        $cleaned = preg_replace('/[^\d+]/', '', $phone);
        
        // Convert 09XX to 639XX
        if (strpos($cleaned, '09') === 0) {
            $cleaned = '63' . substr($cleaned, 1);
        }
        
        // Remove + if present
        $cleaned = str_replace('+', '', $cleaned);
        
        return $cleaned;
    }

    /**
     * Validate child date of birth
     * Must be between 0 and 5 years old
     */
    public static function validateChildDob(string $dob): bool
    {
        try {
            $dobDate = \Carbon\Carbon::parse($dob);
            $minDate = now()->subYears(5);
            $maxDate = now();
            
            return $dobDate->between($minDate, $maxDate);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate vaccine stock
     */
    public static function validateVaccineStock(int $stock): bool
    {
        return $stock >= 0;
    }

    /**
     * Validate email
     */
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate username (alphanumeric and underscore, 3-20 chars)
     */
    public static function validateUsername(string $username): bool
    {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username) === 1;
    }

    /**
     * Validate password strength
     * Minimum 8 characters, at least one uppercase, one lowercase, one number
     */
    public static function validatePasswordStrength(string $password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password) === 1;
    }

    /**
     * Get validation error message
     */
    public static function getPhoneErrorMessage(): string
    {
        return 'Please enter a valid Philippine phone number (e.g., 09XX-XXX-XXXX).';
    }

    public static function getChildDobErrorMessage(): string
    {
        return 'Child date of birth must be within the last 5 years.';
    }

    public static function getPasswordStrengthErrorMessage(): string
    {
        return 'Password must be at least 8 characters with uppercase, lowercase, and numbers.';
    }
}
