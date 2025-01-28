<?php
interface PaymentProcessor {
    public function pay(float $amount): string;
}

class CreditCardPayment implements PaymentProcessor {
    public function pay(float $amount): string {
        return "Kredi kartı ile $amount TL ödeme başarılı.";
    }
}

class PayPalPayment implements PaymentProcessor {
    public function pay(float $amount): string {
        return "PayPal ile $amount TL ödeme başarılı.";
    }
}

class CryptoPayment implements PaymentProcessor {
    public function pay(float $amount): string {
        return "Kripto para ile $amount TL ödeme başarılı.";
    }
}

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$paymentMethod = $data['paymentMethod'] ?? null;
$amount = $data['amount'] ?? null;

if (!$paymentMethod || !$amount || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz giriş. Lütfen geçerli bir tutar ve ödeme yöntemi seçiniz.']);
    exit;
}

try {

    $processor = match ($paymentMethod) {
        'credit_card' => new CreditCardPayment(),
        'paypal' => new PayPalPayment(),
        'crypto' => new CryptoPayment(),
        default => throw new Exception('Bilinmeyen ödeme yöntemi.'),
    };

    $message = $processor->pay((float) $amount);
    echo json_encode(['success' => true, 'message' => $message]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
