# แผนพัฒนาระบบ EOL (English Online)
**สถานะ:** ✅ เสร็จแล้ว | 🔄 กำลังทำ | ⏸️ ยังไม่ได้เริ่มทำ

---

## Phase 1: System Analysis 🔄 กำลังทำ
Version 0.0.1: ออกแบบ Bootstrap ของหน้าเว็บ
- 📁 เอกสาร:
  - `docs/bootstrap_checklist.txt` - ติดตาม Bootstrap 5 implementation
  - `docs/html_pages_checklist.txt` - ติดตามการแก้ไข HTML pages
  - `docs/image_links_checklist.txt` - ติดตามรูปภาพและลิงก์
  - `docs/frontend_development_checklist.txt` - ติดตาม Frontend UI/UX
  - `docs/admin_dashboard_checklist.txt` - เช็กลิสต์ Admin Dashboard (Frontend)

---

## Phase 2: Migration Systems ✅
Version 0.0.2: การแยก code ออกจาก user data และอัพเก็บไว้ใน GitHub
- 📁 เอกสาร:
  - `php/EOL_OLD.txt` - กระบวนการตรวจสอบและ copy ไฟล์ (10 ขั้นตอน)

---
Version 0.0.3: ทำให้รันบน localhost ได้สมบูรณ์ (ไม่มี error)

## Phase 3: Server Migration ⏸️
Version 0.0.4: การเช่า server การเซ็ตอัพ server การตั้งค่าให้ server ทำงานแบบ DevOps
- 💰 ราคา: 390 THB/เดือน (≈ 0.54 THB/ชั่วโมง)(แนะนำให้เช่าทีเดียว 1 ปีด้วยบัญชี บ.)
- 🖥️ ระบบ: Ubuntu 22.04 LTS x64
- ⚙️ สเปค: 2 vCPU, 2 GB RAM, 40 GB SSD
- 🌐 เครือข่าย: External IP ใหม่, Private Network: default
- 🔧 เครื่องมือ:
    - PHP 7.4 สำหรับระบบเดิม และ phpMyAdmin
    - Node.js สำหรับระบบใหม่
    - Cloudflare สำหรับป้องกัน DDoS
    - Nginx (Reverse Proxy)
    - Git สำหรับการดึงโค้ด (pull) เพื่อ deploy
    - Jenkins สำหรับ CI/CD อัปเดตโค้ดอัตโนมัติ ลดความเสี่ยงด้านความปลอดภัยจากการเข้าถึงเซิร์ฟเวอร์ด้วยมนุษย์ (อาจจะไม่ได้ไช้ เพราะยังไม่เข้าจมากพอ)
---

## Phase 4: Data Migration (Operation - ไม่ใช่การพัฒนา) ⏸️
ย้าย data ที่มีอยู่จริง ไม่ใช่ death data ไปยังเซิร์ฟเวอร์ใหม่

---

## Phase 5: Bootstrap Integration ⏸️
Version 1.0.0: การเอา Bootstrap ที่ออกแบบไว้ใน Phase 1 มารวมเข้ากับหน้าเว็บปัจจุบัน
กระบวนการ พัฒนา
1. สร้าง Mockup page
2. ส่งให้พี่เทน
3. รับ การ confirm 
4. git push 
5. jenkin software นำลงไปอัพเดทในทุกสัปดาห์(แล้วแต่ว่าจะตั้งระยะเวลาในการอัพเดทไว้นานแค่ไหน)
---

## Phase 6: PHP API ⏸️
Version 1.1.0: การทำให้ PHP เป็นรูปแบบของ API แยก MVC

---

## Phase 7: Node.js API Server ⏸🔄 กำลังทำ 
Version 2.0.0: ทำเว็บ server API ด้วย Node.js แล้วค่อยๆ ทำให้หน้าเว็บเดิมยิงไปหา API server ใหม่
- 📁 เอกสาร:
  - `docs/api_development_checklist.txt` - แผนการพัฒนา API
  - `docs/API_Login.md` - สเปก API: Login
  - `docs/API_Register.md` - สเปก API: Register
  - `docs/API_ForgotPassword.md` - สเปก API: Forgot Password
  - `docs/API_GetUserData.md` - สเปก API: Get User Data

---

## Phase 8: Full Node.js Migration 🔄 กำลังทำ 
Version 2.1.0: ย้าย server ไปยัง Node แบบ domain เดียวกัน

