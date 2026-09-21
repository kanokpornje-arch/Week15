# ใบงานที่ 15 — RESTful Blog API

## ระบบที่จัดเตรียม

- Laravel Sanctum ติดตั้งแล้ว, migration `personal_access_tokens` ทำงานแล้ว และ User ใช้ `HasApiTokens`
- Register คืน 201 พร้อม Token; Login คืน 200 พร้อม Token; Logout ลบเฉพาะ Token ที่เรียกใช้งาน
- Public: GET `/api/blogs` และ GET `/api/blogs/{id}`
- Protected: GET `/api/user`, POST `/api/logout`, POST `/api/blogs`, PUT `/api/blogs/{id}`, DELETE `/api/blogs/{id}`
- BlogResource คืน id, title, content, status, created_at, updated_at
- รายการเรียงใหม่ไปเก่า แบ่งหน้าละ 10 รายการ; ใช้ `?page=2` ดูหน้าถัดไป
- ข้อมูลไม่ถูกต้องคืน 422; ไม่มี Token/Token ถูกยกเลิกคืน 401; ไม่พบบทความคืน 404

## เปิดระบบ

เปิด MySQL ใน XAMPP แล้วรันจากโฟลเดอร์ `C:\xampp\htdocs\Week15`:

```powershell
C:\xampp\php\php.exe artisan serve --host=127.0.0.1 --port=8000
```

## ทดสอบผ่าน Postman

1. Import ไฟล์ `Week15.postman_collection.json`
2. เลือก Collection ชื่อ **Week15 RESTful Blog API** แล้วกด Run
3. รันครบ 23 คำขอตามลำดับ 1 รอบ โดยไม่ต้องใส่รหัสบัญชีจริง
4. Collection สร้างอีเมลทดสอบใหม่อัตโนมัติ เก็บ Token และ ID บทความให้อัตโนมัติ
5. ทุกคำขอมี Accept และ Content-Type เป็น application/json; คำขอ Protected ใช้ Bearer Token
6. ท้ายชุดลบบทความทดสอบและยกเลิก Token ทั้งสองตัว บัญชีทดสอบยังอยู่ในฐานข้อมูล

## ภาพที่ต้องแนบส่งงาน

ถ่ายภาพจาก Postman หลังรันจริง ให้เห็น method, URL, headers/Authorization, body และ response ตามที่เกี่ยวข้อง:

- Register 201, Login 200, User 200
- รายการและรายละเอียดบทความ 200
- เพิ่ม 201, แก้ไข 200 และลบ 200
- รหัสผ่านผิด 401, เขียนโดยไม่มี Token 401
- ข้อมูลไม่ครบ 422
- Logout 200 และใช้ Token เดิมแล้วได้ 401
- หน้าสรุป Collection Runner

ภาพจาก Postman ต้องเป็นภาพผลรันจริง ไม่ใช่ภาพจำลอง รายงาน Newman เป็นหลักฐานเสริม ไม่ใช่ภาพหน้าจอ Postman

## ตรวจอัตโนมัติ

```powershell
C:\xampp\php\php.exe artisan test --filter='ApiBlogTest|ApiAuthTest|ApiLogoutTest'
```

การทดสอบ Laravel ใช้ SQLite ในหน่วยความจำ แยกจากฐานข้อมูลใช้งานจริง
