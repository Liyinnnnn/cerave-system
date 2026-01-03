# 🧪 Quick Test Guide for Dr. C (Gemini)

## ⚡ Quick Start (2 Minutes)

### 1. Get Your Free API Key
```
1. Visit: https://aistudio.google.com/app/apikey
2. Sign in with Google
3. Click "Create API Key"
4. Copy the key
```

### 2. Add to .env File
```env
GEMINI_API_KEY=paste_your_key_here
```

### 3. Clear Cache
```bash
php artisan config:clear
```

### 4. Test It!
```bash
# Start server
php artisan serve

# Visit: http://localhost:8000/dr-c
```

---

## ✅ Test Scenarios

### Test 1: Basic Response
**Send**: "Hi Dr. C! I need skincare advice."
**Expected**: Friendly greeting + offer to help

### Test 2: Product Recommendations
**Send**: "I have dry skin. What products do you recommend?"
**Expected**: 
- ✅ Mentions dry skin concern
- ✅ Recommends CeraVe products from YOUR database
- ✅ Shows product cards below message
- ✅ Links to your product pages

### Test 3: Multiple Concerns
**Send**: "I have acne and dry skin. Help me build a routine."
**Expected**:
- ✅ Acknowledges both concerns
- ✅ Suggests a routine (cleanse, treat, moisturize)
- ✅ Recommends 2-4 products

### Test 4: Rate Limiting
**Action**: Send 21 messages in one hour
**Expected**: After 20th message, shows rate limit error

### Test 5: Session Tracking
**Action**: Check database after conversation
```sql
SELECT * FROM dr_c_sessions ORDER BY created_at DESC LIMIT 1;
SELECT * FROM dr_c_messages ORDER BY created_at DESC LIMIT 10;
```
**Expected**: Messages saved with proper session_id

---

## 🎯 Success Indicators

✅ **Response time**: 1-3 seconds
✅ **Response quality**: Professional, relevant advice
✅ **Product recommendations**: Only CeraVe products from your DB
✅ **Product links**: Click on products → goes to your product pages
✅ **Session history**: Saved in database
✅ **Rate limit**: Works after 20 messages

---

## 🚨 If Something Goes Wrong

### Error: "Dr. C is experiencing technical difficulties"

**Check 1**: Is your API key correct?
```bash
php artisan tinker
>>> config('services.gemini.api_key')
```

**Check 2**: Did you clear cache?
```bash
php artisan config:clear
```

**Check 3**: Is the API key active?
- Visit: https://aistudio.google.com/app/apikey
- Verify key exists and not deleted

### Error: "Invalid API key"

**Solution**: Check .env file
```env
# Should look exactly like this (no spaces):
GEMINI_API_KEY=AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

### Error: Slow first response (10+ seconds)

**This is normal!** Google's servers need to "wake up" for first request.
Subsequent requests will be 1-2 seconds. ✅

---

## 📊 Verify Database Integration

### Check Products Are Loaded
```sql
SELECT id, name, category FROM products LIMIT 5;
```
**Expected**: Your CeraVe products listed

### Check Messages Are Saved
```sql
SELECT 
    message_type, 
    LEFT(message, 50) as message_preview,
    created_at 
FROM dr_c_messages 
ORDER BY created_at DESC 
LIMIT 5;
```
**Expected**: Your test messages appear

---

## 🎉 You're Done When...

✅ Dr. C responds within 3 seconds
✅ Recommendations are CeraVe products only
✅ Product links work (click → opens product page)
✅ Messages save to database
✅ Rate limiting activates at 20 messages
✅ Interface looks professional and clean

---

## 📝 Quick Reference

| What | Where |
|------|-------|
| Chat Interface | http://localhost:8000/dr-c |
| Get API Key | https://aistudio.google.com/app/apikey |
| Config File | config/services.php |
| Controller | app/Http/Controllers/DrCController.php |
| View | resources/views/dr-c/chat.blade.php |
| Database Tables | dr_c_sessions, dr_c_messages |

---

**Ready to test? Just add your API key and start chatting!** 🚀
