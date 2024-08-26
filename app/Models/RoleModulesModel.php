<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModulesModel extends Model
{
    protected $table            = 'rolemodules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['role_module_id', 'role_id', 'module_id', 'dashboard', 'master_view', 'master_create', 'master_edit', 'master_approval', 'master_delete', 'master_print', 'master_export', 'master_bulk_delete', 'transaction_view', 'transaction_create', 'transaction_edit', 'transaction_approval', 'transaction_delete', 'transaction_print', 'transaction_export', 'transaction_bulk_delete', 'report_view', 'report_print', 'report_export', 'config_view', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}