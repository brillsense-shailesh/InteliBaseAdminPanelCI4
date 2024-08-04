<?php

namespace App\Models;

use App\Models\FunctionModel;

class CityModel extends FunctionModel
{
    // protected $DBGroup          = 'default';
    protected $table            = 'city';
    protected $primaryKey       = 'city_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['city_id', 'city_name', 'country_id', 'state_id'];

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
    protected $validationRules = [
        'city_id' => 'permit_empty',
        'city_name' => 'required|alpha_numeric_space|max_length[255]',
        'country_id' => 'required|integer|is_not_unique[country.country_id]',
        'state_id' => 'required|integer|is_not_unique[state.state_id]',
    ];
    protected $validationMessages = [
        'city_name' => [
            'required' => 'City Name is required.',
            'alpha_numeric_space' => 'Special Character Not Allowed.',
            'max_length' => 'Max Length 255 Character',
        ],
        'country_id' => [
            'required' => 'Country ID is required.',
        ],
        'state_id' => [
            'required' => 'State ID is required.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['allTrim'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['allTrim'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    protected $messageAlias = "City";
    protected $excludeTrimFields = [];

    public function __construct()
    {
        parent::__construct();
        $this->addParentJoin('state_id', $this->get_state_model(), 'left', ['state_name', 'state_code']);
    }
}