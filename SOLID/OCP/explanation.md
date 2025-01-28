# Open-Closed Principle (Açık-Kapalı İlkesi)

### **Nedir?**
- **Açık:** Yeni işlevsellik eklemek için kod genişletilebilir olmalıdır.
- **Kapalı:** Mevcut kod, yeni işlevsellik eklemek için değiştirilmek zorunda kalmamalıdır.

Bu prensip, yazılımın genişletilebilirliğini ve bakımını kolaylaştırır. Amacı, mevcut kodu bozma riski olmadan yeni özellikler eklenmesini sağlamaktır.

---

### **Kodda Açık-Kapalı İlkesi Nasıl Uygulanıyor?**

#### 1. **Arayüz (Interface) Kullanımı**
- Projede `PaymentProcessor` adında bir **arayüz** tanımlandı.
- Bu arayüz, tüm ödeme sınıflarının uygulamak zorunda olduğu bir metodu (`pay`) içeriyor.
- Yeni ödeme yöntemleri eklemek için bu arayüzden türeyen sınıflar oluşturulabilir.

**Örnek:**
```php
interface PaymentProcessor {
    public function pay(float $amount): string;
}
```

#### 2. **Mevcut Ödeme Sınıfları**
- Her ödeme yöntemi için bir sınıf oluşturulmuş ve bu sınıflar `PaymentProcessor` arayüzünü implement ediyor.
  
**Örnek Sınıflar:**
```php
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
```

#### 3. **Yeni Ödeme Yöntemi Eklemek**
- Örneğin, sisteme yeni bir ödeme yöntemi eklemek istiyorsak (örneğin **Mobil Ödeme**), sadece şu sınıfı tanımlamamız yeterli olur:

```php
class MobilePayment implements PaymentProcessor {
    public function pay(float $amount): string {
        return "Mobil ödeme ile $amount TL ödeme başarılı.";
    }
}
```

- Daha sonra bu sınıf, `match` bloğuna eklenir:

```php
$processor = match ($paymentMethod) {
    'credit_card' => new CreditCardPayment(),
    'paypal' => new PayPalPayment(),
    'crypto' => new CryptoPayment(),
    'mobile' => new MobilePayment(), // Yeni ödeme yöntemi
    default => throw new Exception('Bilinmeyen ödeme yöntemi.'),
};
```

**Sonuç:**
- Mevcut kodları değiştirmeden yeni bir ödeme yöntemi eklenmiş oldu.
- Sistemin diğer parçaları (ör. frontend) hiçbir değişiklik gerektirmedi.

---

### **Backend ile Uyumluluk**
- `PaymentProcessor` arayüzü, tüm ödeme sınıflarının aynı yöntemi (`pay`) uygulamasını zorunlu kılar.
- Bu sayede frontend, hangi ödeme yöntemi seçilirse seçilsin, backend'den standart bir yanıt alır.
  
---

### **Açık-Kapalı İlkesinin Avantajları**
1. **Genişlemeye Açıklık:**
   - Yeni ödeme yöntemleri kolayca eklenebilir.
   - Örneğin, mobil ödeme, havale gibi yöntemler eklemek için sadece yeni bir sınıf tanımlanması yeterlidir.
2. **Değişikliğe Kapalılık:**
   - Mevcut ödeme yöntemlerinde veya sistem mimarisinde değişiklik yapılması gerekmez.
3. **Soyutlama (Abstraction):**
   - `PaymentProcessor` arayüzü, tüm ödeme sınıflarının ortak bir davranışa sahip olmasını sağlar.
4. **Hata Riskinin Azalması:**
   - Mevcut kod değişmediği için, yeni eklemeler nedeniyle eski işlevselliğin bozulma riski düşer.

---

### **Sonuç**
Bu projede **Open-Closed Principle** şu şekilde uygulandı:
- Yeni özellikler eklemek için mevcut kod değiştirilmek zorunda kalmadı.
- Kod genişletilebilir bir yapıya sahip oldu.
- Hem frontend hem de backend tarafında minimal eforla yeni ödeme yöntemleri eklenebilir.
