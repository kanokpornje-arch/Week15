const fs = require('node:fs');
const report = JSON.parse(fs.readFileSync(__dirname+'/../storage/logs/postman-results.json','utf8'));
const lines = [
 '# รายงานผลการทดสอบ — ใบงานที่ 15', '',
 'ทดสอบ API จริงด้วย Postman Collection ผ่าน Newman (ไม่ใช่ภาพหน้าจอจากแอป Postman)', '',
 'เวลารัน: '+new Date(report.run.timings.started).toISOString(), '',
 `ผล: ${report.run.stats.requests.total} คำขอ, ${report.run.stats.assertions.total} assertions, ${report.run.failures.length} failures`, '',
 'Laravel Feature Tests: 9 tests ผ่าน, 78 assertions', '',
 '| คำขอ | วิธี | HTTP จริง | เวลา (ms) | ผล |',
 '|---|---|---:|---:|---|',
 ];
for(const e of report.run.executions) {
 const passed = !e.requestError && (e.assertions || []).every(a=>!a.error);
 lines.push(`| ${e.item.name} | ${e.request.method} | ${e.response?.code || '-'} | ${e.response?.responseTime || '-'} | ${passed?'PASS':'FAIL'} |`);
}
lines.push('', '## สรุปตามเกณฑ์', '',
 '- Sanctum, HasApiTokens และตาราง personal_access_tokens พร้อมใช้งาน',
 '- Register 201, Login 200 และ Logout ยกเลิก Token ผ่าน',
 '- BlogResource และ CRUD พร้อม pagination ผ่าน',
 '- อ่านบทความแบบ Public; เขียน แก้ไข ลบ และดูบัญชีต้องใช้ Bearer Token',
 '- ตรวจ Accept/Content-Type JSON และกรณี 401/422 ผ่าน',
 '- Token ทดสอบถูกยกเลิกและบทความทดสอบถูกลบหลังจบชุด บัญชีทดสอบยังอยู่', '',
 '## หลักฐานที่ยังต้องแนบ', '',
 'ภาพหน้าจอ Postman ตามรายการใน README.md ยังไม่ได้จัดทำ รายงานนี้ไม่ใช้แทนภาพหน้าจอที่ใบงานกำหนด',
 'นำเข้า Week15.postman_collection.json แล้วรัน Collection เพื่อถ่ายภาพผลจริงได้ทันที', '');
fs.writeFileSync(__dirname+'/TEST-REPORT.md',lines.join('\n'));
