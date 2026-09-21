# รายงานผลการทดสอบ — ใบงานที่ 15

ทดสอบ API จริงด้วย Postman Collection ผ่าน Newman (ไม่ใช่ภาพหน้าจอจากแอป Postman)

เวลารัน: 2026-09-21T09:29:19.973Z

ผล: 23 คำขอ, 46 assertions, 0 failures

Laravel Feature Tests: 9 tests ผ่าน, 78 assertions

| คำขอ | วิธี | HTTP จริง | เวลา (ms) | ผล |
|---|---|---:|---:|---|
| 1. Register | POST | 201 | 354 | PASS |
| 2. Duplicate registration | POST | 422 | 109 | PASS |
| 3. Invalid registration | POST | 422 | 101 | PASS |
| 4. Wrong password | POST | 401 | 323 | PASS |
| 5. Invalid login | POST | 422 | 92 | PASS |
| 6. Login | POST | 200 | 300 | PASS |
| 7. User without token | GET | 401 | 99 | PASS |
| 8. User with token | GET | 200 | 151 | PASS |
| 9. Public list | GET | 200 | 120 | PASS |
| 10. Create without token | POST | 401 | 93 | PASS |
| 11. Invalid blog | POST | 422 | 147 | PASS |
| 12. Create blog | POST | 201 | 121 | PASS |
| 13. Public detail | GET | 200 | 99 | PASS |
| 14. Update without token | PUT | 401 | 93 | PASS |
| 15. Invalid update | PUT | 422 | 145 | PASS |
| 16. Update blog | PUT | 200 | 140 | PASS |
| 17. Delete without token | DELETE | 401 | 87 | PASS |
| 18. Delete blog | DELETE | 200 | 138 | PASS |
| 19. Missing blog | GET | 404 | 99 | PASS |
| 20. Logout without token | POST | 401 | 96 | PASS |
| 21. Logout | POST | 200 | 147 | PASS |
| 22. Revoked token | GET | 401 | 102 | PASS |
| 23. Revoke registration token | POST | 200 | 135 | PASS |

## สรุปตามเกณฑ์

- Sanctum, HasApiTokens และตาราง personal_access_tokens พร้อมใช้งาน
- Register 201, Login 200 และ Logout ยกเลิก Token ผ่าน
- BlogResource และ CRUD พร้อม pagination ผ่าน
- อ่านบทความแบบ Public; เขียน แก้ไข ลบ และดูบัญชีต้องใช้ Bearer Token
- ตรวจ Accept/Content-Type JSON และกรณี 401/422 ผ่าน
- Token ทดสอบถูกยกเลิกและบทความทดสอบถูกลบหลังจบชุด บัญชีทดสอบยังอยู่

## หลักฐานที่ยังต้องแนบ

ภาพหน้าจอ Postman ตามรายการใน README.md ยังไม่ได้จัดทำ รายงานนี้ไม่ใช้แทนภาพหน้าจอที่ใบงานกำหนด
นำเข้า Week15.postman_collection.json แล้วรัน Collection เพื่อถ่ายภาพผลจริงได้ทันที
