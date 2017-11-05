<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function index() {
        redirect_if_not_login();

        // get all products
        $data['products'] = $this->products->get_all();
        $data['account'] = $account = $this->session->userdata['logged_in'];

        // flush data to view
        $this->load->view('product_list', $data);
    }

    /**
     * Index Page for this controller
     */
    public function add() {
        redirect_if_not_login();

        //Current logged account
        $data['account'] = $account = $this->session->userdata['logged_in'];

        $data['product_types'] = $this->types->get_all_product_types();

        if ($this->input->method() == 'post') {
            $product_data['name'] = $name = $this->input->post('name');
            $product_data['product_type'] = $product_type = $this->input->post('product_type');
            $product_data['current_quantity'] = $current_quantity = $this->input->post('current_quantity');
            $currentDate = time();
            $product_data['created'] = $product_data['modified'] = $currentDate;
            $product_data['creator'] = $product_data['modifier'] = $account->id;
            $this->products->add($product_data);
            $this->session->set_flashdata('redirect', true);
            $this->session->set_flashdata('message'
                    , "Producto guardado, Nombre: {$name}");
        }

        $data['redirect_time'] = $this->config->item('redirect_time');

        // flush data to view
        $this->load->view('product_edit', $data);
    }

    public function edit($product_id) {

        //Current logged account
        redirect_if_not_login();

        $data['account'] = $account = $this->session->userdata['logged_in'];

        $data['product'] = $product = $this->products->one($product_id);
        $data['product_types'] = $this->types->get_all_product_types();

        if ($this->input->method() == 'post') {
            $product_data = [];
            if ($this->input->post('name')) {
                $product_data['name'] = $name = $this->input->post('name');
            } else {
                $product_data['name'] = $name = $product->name;
            }
            if ($this->input->post('product_type')) {
                $product_data['product_type'] = $product_type = $this->input->post('product_type');
            }
            if ($this->input->post('current_quantity')) {
                $product_data['current_quantity'] = $product_type = $this->input->post('current_quantity');
            }
            $product_data['modified'] = time();
            $product_data['modifier'] = $account->id;


            $this->products->update($product_id, $product_data);
            $this->session->set_flashdata('redirect', true);
            $this->session->set_flashdata('message'
                    , "Producto guardado, Nombre: {$name}");
        }

        $data['redirect_time'] = $this->config->item('redirect_time');

        // flush data to view
        $this->load->view('product_edit', $data);
    }

    public function inventory($product_id) {

        redirect_if_not_login();

        $data['account'] = $account = $this->session->userdata['logged_in'];

        $data['product'] = $product = $this->products->one($product_id);

        if ($this->input->method() == 'post') {

            $entry_type = $this->input->post('entry_type');
            $movement = intval($this->input->post('movement'));
            if ($entry_type === 'out') {
                $movement *= -1;
            }
            $product->current_quantity += $movement;

            $inventory_data = [
                'product' => $product_id,
                'in' => $entry_type === 'in' ? $movement : 0,
                'out' => $entry_type === 'out' ? $movement : 0,
                'current_quantity' => $product->current_quantity,
                'created' => time(),
                'creator' => $account->id
            ];
            $product_data = [
                'current_quantity' => $product->current_quantity,
                'modified' => time(),
                'modifier' => $account->id
            ];

            $this->inventory->add($inventory_data);
            $this->products->update($product_id, $product_data);
            $this->session->set_flashdata('redirect', true);
            $this->session->set_flashdata('message'
                    , "Movimiento de producto guardado, Nombre: {$product->name}");
        }

        $data['redirect_time'] = $this->config->item('redirect_time');
        $data['default_inventory_movement'] = $this->config->item('default_inventory_movement');

        // flush data to view
        $this->load->view('product_inventory', $data);
    }
    
    public function report($report_name) {
        if ($report_name === 'inventory') {
            return $this->report_inventory();
        }
    }
    
    public function report_inventory() {
        $records = $this->inventory->inventory_report();
        
        $data = [];
        $data['account'] = $account = $this->session->userdata['logged_in'];
        
        $formated_records = [];
        
        foreach($records as $record) {
            $r = [
                'product_type' => $record->product_type,
                'product' => $record->product,
                'name' => $record->name,
                'year_week' => str_replace(' ', '-', $record->year_week),
                'day_0'=>0,
                'day_1'=>0,
                'day_2'=>0,
                'day_3'=>0,
                'day_4'=>0,
                'day_5'=>0,
                'day_6'=>0,
            ];
            $formated_days = [];
            $days = explode(';',$record->result);
            foreach ($days as $day){
                $daysData = explode(',', $day);
                $r['day_'.$daysData[0]] = abs(intval($daysData[1]));
            }
            $formated_records[] = $r;
        }
        
        $data['records'] = $formated_records;
        
        // flush data to view
        $this->load->view('product_report_inventory', $data);
    }

    public function save_test_data($from = '2018-01-01', $to = '2018-01-31') {
        
        return false;

        $products = $this->products->get_all();

        $fromDate = new DateTime($from);
        $toDate = new DateTime($to);

        foreach ($products as $product) {
            $virtualToday = new DateTime($from);
            do {
                $limit = rand(1, 5);
                for ($i = 0; $i < $limit; $i++) {
                    if (rand(1, 2) > 1) {
                        $movement = rand(1, 10);
                        echo "{$virtualToday->format('Y-m-d')} {$product->name}: si, {$movement}";
                        
                        $entry_type = 'out';
                        if ($entry_type === 'out') {
                            $movement *= -1;
                        }
                        $product->current_quantity += $movement;

                        $inventory_data = [
                            'product' => $product->id,
                            'in' => $entry_type === 'in' ? $movement : 0,
                            'out' => $entry_type === 'out' ? $movement : 0,
                            'current_quantity' => $product->current_quantity,
                            'created' => $virtualToday->getTimestamp(),
                            'creator' => 1
                        ];
                        $product_data = [
                            'current_quantity' => $product->current_quantity,
                            'modified' => $virtualToday->getTimestamp(),
                            'modifier' => 1
                        ];

                        $this->inventory->add($inventory_data);
                        $this->products->update($product->id, $product_data);
                    } else {
                        echo "{$virtualToday->format('Y-m-d')} {$product->name}: no";
                    }
                    echo "<br />";
                }
                $virtualToday->modify('+1 day');
            } while ($virtualToday->getTimestamp() <= $toDate->getTimestamp());
        }
    }

}
