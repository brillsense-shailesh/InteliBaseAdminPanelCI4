<?php

namespace App\Database\Migrations;

use App\Traits\CommonTraits;
use CodeIgniter\Database\Migration;
use UserType;

class UserTable extends Migration
{
    use CommonTraits;
    public function up()
    {
        helper('commonfunction');
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'reporting_to_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'designation_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => false
            ],
            'user_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true
            ],
            'user_address' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'user_country_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'user_state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'user_city_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'user_pincode' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
            ],
            'user_aadhaar_card' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'user_aadhaar_card_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'user_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'user_type' => [
                'type' => 'ENUM',
                'constraint' => [
                    'super_admin',
                    'admin',
                    'sales_manager',
                    'sales_executive',
                    'purchase',
                    'finance',
                    'crm'
                ],
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true, // assuming OTP might not always be present
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addPrimaryKey('user_id');
        $this->forge->addForeignKey('user_country_id', 'country', 'country_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('user_state_id', 'state', 'state_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('user_city_id', 'city', 'city_id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('designation_id', 'designation', 'designation_id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('user', true);
        $this->forge->addForeignKey('reporting_to_user_id', 'user', 'user_id', 'RESTRICT', 'RESTRICT');
        $super_admin_data = [
            'user_name' => 'Shailesh Jain',
            'designation_id' => 1,
            'user_email' => 'shaileshjain925@gmail.com',
            'password' => "7879531944",
            'user_mobile' => "7879531944",
            'user_address' => "74 Sai Nath Colony Ujjain",
            'user_country_id' => 101,
            'user_state_id' => 4039,
            'user_city_id' => 134263,
            'user_pincode' => 456001, // Replace with actual pincode if needed
            'user_aadhaar_card' => null,
            'user_aadhaar_card_image' => null,
            'user_image' => null,
            'user_type' => 'super_admin', // Assuming SUPER_ADMIN is defined in your UserType class
            'is_active' => true,
        ];

        if (empty($this->get_user_model()->first())) {
            $this->get_user_model()->insert($super_admin_data);
        }
    }

    public function down()
    {
        $this->forge->dropTable('user', true);
    }
}
