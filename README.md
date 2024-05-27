# ระบบข้อมูลการจัดการขายออนไลน์ขนาดเล็ก

เป็นเว็บแอปพลิเคชัน ทางคณะผู้จัดทำก็เป็นหนึ่งในบุคคลที่มีร้านค้าออนไลน์ ที่เล็งเห็นถึงปัญหาต่างๆของร้านค้า เช่น จัดการรายการขายที่ไม่เป็นระบบ การบริหารจัดการข้อมูลของลูกค้า จนกระทั่งการวัดผลประกอบการ และทางคณะผู้จัดทำได้สร้างระบบที่จะมาช่วยเหลือร้านค้าให้สามารถจัดการร้านค้าได้ง่ายขึ้น การวางแผนและจัดสรรทรัพยากรในร้านค้าให้เท่ากับอุปสงค์ของผู้ที่ต้องการซื้อขายและอุปทานของผู้ขายได้เท่ากันเพื่อไม่ให้เกิดการขาดแคลนสินค้าหรือไม่เป็นการกักตุนสินค้ามากจนเกินไป ด้วยเหตุนี้ทางผู้พัฒนาจึงมีแนวคิดในการพัฒนาเว็บแอปพลิเคชัน ช่วยดูแลการทำงานของร้านค้าออนไลน์เพื่ออำนวยความสะดวกให้แก่ร้านค้าออนไลน์ขนาดเล็ก ในการดูแลเรื่อง การสร้างรายการขาย การจัดการพนักงานในร้าน การวัดผลประกอบการ และการแจ้งเตือนสินค้าใกล้หมดด้วยการนำแอปพลิเคชัน LINE มาประยุกต์ใช้ โดยจัดการร้านค้าจะสามารถรับการแจ้งเตือนสินค้าที่ใกล้หมดและการ Log in หรือ Log out ของพนักงานในร้านได้
โดยการพัฒนาจะใช้  HTML CSS JS BOOSTRAP  เป็นส่วนของหน้าเว็บ 
 PHP ติดต่อเชื่อมต่อสื่อสารกับ  Database MySQL เป็นฐานข้อมูลที่ใช้สำหรับเก็บข้อมูลในส่วนต่างๆ  และ Line API  (Line Notify  )เพื่อส่งข้อมูลให้ร้านค้าในการแจ้งเตือนต่างๆให้กับผู้ใช้

# Directory tree 
├───assets
│   ├───css
│   ├───img
│   ├───js
│   ├───scss
│   └───vendor
│       ├───apexcharts
│       │   └───locales
│       ├───bootstrap
│       │   ├───css
│       │   └───js
│       ├───bootstrap-icons
│       │   └───fonts
│       ├───boxicons
│       │   ├───css
│       │   └───fonts
│       ├───chart.js
│       │   ├───chunks
│       │   ├───controllers
│       │   ├───core
│       │   ├───elements
│       │   ├───helpers
│       │   ├───platform
│       │   ├───plugins
│       │   │   └───plugin.filler
│       │   ├───scales
│       │   └───types
│       ├───echarts
│       │   └───extension
│       ├───php-email-form
│       ├───quill
│       ├───remixicon
│       ├───simple-datatables
│       └───tinymce
│           ├───icons
│           │   └───default
│           ├───models
│           │   └───dom
│           ├───plugins
│           │   ├───accordion
│           │   ├───advlist
│           │   ├───anchor
│           │   ├───autolink
│           │   ├───autoresize
│           │   ├───autosave
│           │   ├───charmap
│           │   ├───code
│           │   ├───codesample
│           │   ├───directionality
│           │   ├───emoticons
│           │   │   └───js
│           │   ├───fullscreen
│           │   ├───help
│           │   │   └───js
│           │   │       └───i18n
│           │   │           └───keynav
│           │   ├───image
│           │   ├───importcss
│           │   ├───insertdatetime
│           │   ├───link
│           │   ├───lists
│           │   ├───media
│           │   ├───nonbreaking
│           │   ├───pagebreak
│           │   ├───preview
│           │   ├───quickbars
│           │   ├───save
│           │   ├───searchreplace
│           │   ├───table
│           │   ├───template
│           │   ├───visualblocks
│           │   ├───visualchars
│           │   └───wordcount
│           ├───skins
│           │   ├───content
│           │   │   ├───dark
│           │   │   ├───default
│           │   │   ├───document
│           │   │   ├───tinymce-5
│           │   │   ├───tinymce-5-dark
│           │   │   └───writer
│           │   └───ui
│           │       ├───oxide
│           │       ├───oxide-dark
│           │       ├───tinymce-5
│           │       └───tinymce-5-dark
│           └───themes
│               └───silver
├───ecommerce
│   ├───assets
│   │   ├───css
│   │   ├───img
│   │   ├───js
│   │   ├───scss
│   │   └───vendor
│   │       ├───apexcharts
│   │       │   └───locales
│   │       ├───bootstrap
│   │       │   ├───css
│   │       │   └───js
│   │       ├───bootstrap-icons
│   │       │   └───fonts
│   │       ├───boxicons
│   │       │   ├───css
│   │       │   └───fonts
│   │       ├───chart.js
│   │       │   ├───chunks
│   │       │   ├───controllers
│   │       │   ├───core
│   │       │   ├───elements
│   │       │   ├───helpers
│   │       │   ├───platform
│   │       │   ├───plugins
│   │       │   │   └───plugin.filler
│   │       │   ├───scales
│   │       │   └───types
│   │       ├───echarts
│   │       │   └───extension
│   │       ├───php-email-form
│   │       ├───quill
│   │       ├───remixicon
│   │       ├───simple-datatables
│   │       └───tinymce
│   │           ├───icons
│   │           │   └───default
│   │           ├───models
│   │           │   └───dom
│   │           ├───plugins
│   │           │   ├───accordion
│   │           │   ├───advlist
│   │           │   ├───anchor
│   │           │   ├───autolink
│   │           │   ├───autoresize
│   │           │   ├───autosave
│   │           │   ├───charmap
│   │           │   ├───code
│   │           │   ├───codesample
│   │           │   ├───directionality
│   │           │   ├───emoticons
│   │           │   │   └───js
│   │           │   ├───fullscreen
│   │           │   ├───help
│   │           │   │   └───js
│   │           │   │       └───i18n
│   │           │   │           └───keynav
│   │           │   ├───image
│   │           │   ├───importcss
│   │           │   ├───insertdatetime
│   │           │   ├───link
│   │           │   ├───lists
│   │           │   ├───media
│   │           │   ├───nonbreaking
│   │           │   ├───pagebreak
│   │           │   ├───preview
│   │           │   ├───quickbars
│   │           │   ├───save
│   │           │   ├───searchreplace
│   │           │   ├───table
│   │           │   ├───template
│   │           │   ├───visualblocks
│   │           │   ├───visualchars
│   │           │   └───wordcount
│   │           ├───skins
│   │           │   ├───content
│   │           │   │   ├───dark
│   │           │   │   ├───default
│   │           │   │   ├───document
│   │           │   │   ├───tinymce-5
│   │           │   │   ├───tinymce-5-dark
│   │           │   │   └───writer
│   │           │   └───ui
│   │           │       ├───oxide
│   │           │       ├───oxide-dark
│   │           │       ├───tinymce-5
│   │           │       └───tinymce-5-dark
│   │           └───themes
│   │               └───silver
│   └───forms
└───forms


# ขั้นตอนการติดตั้งและเปิดใช้งาน
1. ติดตั้ง  https://www.apachefriends.org/ (XAMPP)
2. ย้าย Folder โปรเจกต์ 66-1_05_nng-r2 ไปยัง /XAMPP/htdogs
3. รัน Apache และ MySQL
4. เข้าสู่ localhost/phpmyadmin ที่บราวเซอร์
5. กด New สร้าง Database ใหม่ ชื่อ e-commerce
6. ดาวน์โหลด ไฟล์ Database.sql ที่อยู่ในโฟลเดอร์ /src เข้าสู่ mysql
7.  กด Import เลือกไฟล์ Database.sql กด import
8. เข้าสู่ localhost/66-1_05_nng-r2 ที่บราวเซอร์
9.  คลิก /src
10. ใช้งานเว็บ 

# เครดิต
นางสาว ธมลวรรณ พรหมทอง (ผู้พัฒนา)
นางสาว อรภิญญา แจ่มศรี(ผู้พัฒนา)

