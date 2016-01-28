<?php
// Heading
$_['heading_title']        = 'สกุลเงิน';  

// Text
$_['text_success']         = 'สถานะ การแก้ไขข้อมูลเสร็จสมบูรณ์!';

// Column
$_['column_title']         = 'ชื่อสกุลเงิน';
$_['column_code']          = 'ตัวย่อ'; 
$_['column_value']         = 'อัตราแลกเปลี่ยน';
$_['column_date_modified'] = 'ปรับปรุงล่าสุด';
$_['column_action']        = 'ดำเนินการ';

// Entry
$_['entry_title']          = 'ชื่อสกุลเงิน:';
$_['entry_code']           = 'ตัวย่อ:<br /><span class="help">Do not change if this is your default currency. Must be valid <a href="http://www.xe.com/iso4217.php" target="_blank">ISO code</a>.</span>';
$_['entry_value']          = 'อัตราแลกเปลี่ยน:<br /><span class="help">ใส่ค่าเป็น 1.00000 สำหรับสกุลเงินที่ใช้เป็นค่าตั้งต้น.</span>';
$_['entry_symbol_left']    = 'สัญลักษณ์ แสดงด้านหน้า:';
$_['entry_symbol_right']   = 'สัญลักษณ์ แสดงด้านหลัง:';
$_['entry_decimal_place']  = 'จุดทศนิยม:';
$_['entry_status']         = 'สถานะ:';

// Error
$_['error_permission']     = 'คุณไม่มีสิทธิ์ในการแก้ไขสกุลเงิน!';
$_['error_title']          = 'สกุลเงิน ต้องมีความยาวไม่น้อยกว่า 3 และไม่เกิน 32 ตัวอักษร!';
$_['error_code']           = 'สกุลเงิน ต้องมีความยาว 3 ตัวอักษรเท่านั้น!';
$_['error_default']        = 'Warning: This currency cannot be deleted as it is currently assigned as the default store currency!';
$_['error_store']          = 'Warning: This currency cannot be deleted as it is currently assigned to %s stores!';
$_['error_order']          = 'Warning: This currency cannot be deleted as it is currently assigned to %s orders!';
?>