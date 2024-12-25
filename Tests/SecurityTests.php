<?php
use PHPUnit\Framework\TestCase;

class SecurityTests extends TestCase
{
    // Test de Protection des Mots de Passe
    public function testPasswordHashing()
    {
        $password = "SecurePass123!";
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->assertTrue(password_verify($password, $hashedPassword));
    }

    public function testPasswordNotStoredInPlainText()
    {
        $password = "SecurePass123!";
        $hashedPassword = md5($password);
        $this->assertNotEquals($password, $hashedPassword);
    }

    // Test Anti-Injection SQL
    public function testSqlInjectionProtection()
    {
        $email = "test@example.com";
        $stmt = $this->prepareStatement($email);
        $this->assertTrue($stmt);
    }

    private function prepareStatement($email)
    {
        $conn = new mysqli('localhost', 'root', '93230Elielfresnel', 'register');
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }

    // Test Protection XSS
    public function testXssProtection()
    {
        $input = "<script>alert('XSS');</script>";
        $cleanInput = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        $this->assertEquals("&lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;", $cleanInput);
    }

    // Test Protection CSRF
    public function testCsrfTokenValidation()
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $token = $_SESSION['csrf_token'];
        $this->assertTrue($this->validateCsrfToken($token));
    }

    private function validateCsrfToken($token)
    {
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    // Test de Sécurité des Sessions
    public function testSessionSecurity()
    {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.use_strict_mode', 1);

        $this->assertEquals('1', ini_get('session.cookie_httponly'));
        $this->assertEquals('1', ini_get('session.cookie_secure'));
        $this->assertEquals('1', ini_get('session.use_strict_mode'));
    }

    // Test de Protection des Données
    public function testSensitiveDataEncryption()
    {
        $data = "SensitiveData";
        $encryptedData = $this->encryptData($data);
        $this->assertNotEquals($data, $encryptedData);
        $this->assertEquals($data, $this->decryptData($encryptedData));
    }

    private function encryptData($data)
    {
        $encryption_key = base64_decode('your-encryption-key');
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    private function decryptData($data)
    {
        $encryption_key = base64_decode('your-encryption-key');
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
}