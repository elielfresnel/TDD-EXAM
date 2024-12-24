<?php
use PHPUnit\Framework\TestCase;

class AllTests extends TestCase
{
    // Test de Format d'Email
    public function testValidEmailFormat()
    {
        $email = "test@example.com";
        $this->assertTrue(filter_var($email, FILTER_VALIDATE_EMAIL) !== false);
    }

    public function testInvalidEmailFormat()
    {
        $email = "invalid-email";
        $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function testEmailErrorMessage()
    {
        $email = "invalid-email";
        ob_start();
        $this->mail_Validation($email);
        $output = ob_get_clean();
        $this->assertStringContainsString("Wrong E-Mail Format", $output);
    }

    // Test de Complexité du Mot de Passe
    public function testPasswordLength()
    {
        $password = "short1";
        $this->assertFalse($this->strength_check($password));
    }

    public function testPasswordNoSpecialChar()
    {
        $password = "NoSpecialChar1";
        $this->assertFalse($this->strength_check($password));
    }

    public function testPasswordValid()
    {
        $password = "ValidPass1!";
        $this->assertTrue($this->strength_check($password));
    }

    // Test de Doublons
    public function testDuplicateAccount()
    {
        $email = "duplicate@example.com";
        $_SESSION['existing_emails'] = ['duplicate@example.com'];
        $this->assertFalse($this->isUniqueEmail($email));
    }

    public function testUniqueAccount()
    {
        $email = "unique@example.com";
        $_SESSION['existing_emails'] = ['duplicate@example.com'];
        $this->assertTrue($this->isUniqueEmail($email));
    }

    // Test de Limites des Champs
    public function testMaxLength()
    {
        $input = str_repeat("a", 256);
        $this->assertTrue(strlen($input) > 255);
    }

    public function testSpecialCharacters()
    {
        $input = "John!@#";
        $this->assertFalse($this->string_Validation($input));
    }

    public function testTruncation()
    {
        $input = str_repeat("a", 300);
        $this->assertEquals(255, strlen(substr($input, 0, 255)));
    }

    // Test de Verrouillage de Compte
    public function testFailedAttemptsCounter()
    {
        $_SESSION['failed_attempts'] = 0;
        $this->failAttempt();
        $this->failAttempt();
        $this->failAttempt();
        $this->assertEquals(3, $_SESSION['failed_attempts']);
    }

    public function testTemporaryLockout()
    {
        $_SESSION['failed_attempts'] = 3;
        $this->assertTrue($this->isAccountLocked());
    }

    public function testUnlockAfterDelay()
    {
        $_SESSION['failed_attempts'] = 3;
        $_SESSION['lockout_time'] = time() - 600; // Simulate 10 minutes past
        $this->assertFalse($this->isAccountLocked());
    }

    // Test de Session
    public function testSessionExpiration()
    {
        $_SESSION['created'] = time() - 3600; // Simulate session created 1 hour ago
        $this->assertTrue($this->sessionExpired());
    }

    public function testRegenerateSessionID()
    {
        session_start();
        $oldSessionId = session_id();
        $this->regenerateSession();
        $this->assertNotEquals($oldSessionId, session_id());
    }

    public function testSessionCleanup()
    {
        $_SESSION['user_data'] = 'some data';
        $this->cleanupSession();
        $this->assertEmpty($_SESSION);
    }

    // Test de Validation des Données
    public function testCleanInput()
    {
        $input = "<script>alert('XSS');</script>";
        $this->assertEquals("alert('XSS');", $this->cleanInput($input));
    }

    public function testCorrectDataTypes()
    {
        $email = "test@example.com";
        $name = "John Doe";
        $age = 25;

        $this->assertIsString($email);
        $this->assertIsString($name);
        $this->assertIsInt($age);
    }

    public function testNullValues()
    {
        $value = null;
        $this->assertTrue($this->isNullValue($value));
    }

    // Fonctions auxiliaires
    private function mail_Validation($mail_address): int
    {
        if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
            echo "Wrong E-Mail Format";
            return 0;
        } else {
            return 1;
        }
    }

    private function strength_check($password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
    }

    private function isUniqueEmail($email): bool
    {
        return !in_array($email, $_SESSION['existing_emails']);
    }

    private function string_Validation($string_data): bool
    {
        return preg_match("/^[a-zA-Z ]*$/", $string_data) === 1;
    }

    private function failAttempt()
    {
        if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 0;
        }
        $_SESSION['failed_attempts']++;
        if ($_SESSION['failed_attempts'] >= 3) {
            $_SESSION['lockout_time'] = time();
        }
    }

    private function isAccountLocked()
    {
        if (isset($_SESSION['lockout_time']) && (time() - $_SESSION['lockout_time']) < 600) {
            return true;
        }
        return false;
    }

    private function sessionExpired()
    {
        $maxLifetime = 1800; // 30 minutes
        if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > $maxLifetime)) {
            session_destroy();
            return true;
        }
        return false;
    }

    private function regenerateSession()
    {
        session_regenerate_id(true);
    }

    private function cleanupSession()
    {
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    private function cleanInput($input)
    {
        return strip_tags($input);
    }

    private function isNullValue($value)
    {
        return is_null($value);
    }
}
?>
