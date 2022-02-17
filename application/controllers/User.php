<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $arr = array();
    private $arr2 = array();
    private $arrPointL = array();
    private $arrPointR = array();
    private $arrTodayL = array();
    private $arrTodayR = array();
    private $arrPointSpon = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('mailer');
        $this->load->library('GoogleAuthenticator');

        $this->load->model('M_user');
        $this->load->helper(array('form', 'url'));
    }

    public function flag($code)
    {
        $flag = "";

        if ($code == '62') {
            $flag = 'indonesia.png';
        } elseif ($code == '82') {
            $flag = 'south-korea.png';
        } elseif ($code == '1') {
            $flag = 'united-states.png';
        } elseif ($code == '44') {
            $flag = 'united-kingdom.png';
        } elseif ($code == '66') {
            $flag = 'china.png';
        } elseif ($code == '84') {
            $flag = 'vietnam.png';
        } elseif ($code == '86') {
            $flag = 'thailand.png';
        }

        return $flag;
    }

    public function box($name)
    {
        $box = "";

        if ($name < 3) {
            $box = '1box.png';
        } elseif ($name >= 3 &&  $name < 9) {
            $box = '3box.png';
        } elseif ($name >= 9 &&  $name < 15) {
            $box = '9box.png';
        } elseif ($name >= 15 &&  $name < 30) {
            $box = '15box.png';
        } elseif ($name >= 30 &&  $name < 60) {
            $box = '30box.png';
        } elseif ($name >= 60 &&  $name < 120) {
            $box = '60box.png';
        } elseif ($name >= 120 &&  $name < 300) {
            $box = '120box.png';
        } elseif ($name >= 300 &&  $name < 540) {
            $box = '300box.png';
        } elseif ($name >= 540) {
            $box = '540box.png';
        } else {
            $box = '0box.png';
        }

        return $box;
    }

    public function index()
    {
        $this->_unset_payment();
        $dateNow = date('Y-m-d');

        //update notif
        if (!empty($this->uri->segment(3))) {
            $data_notif = [
                'is_show' => 1
            ];

            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $this->uri->segment(3));
        }

        $data['news']              = $this->M_user->get_all_news()->row_array();
        $data['news_limit']        = $this->M_user->get_all_news_limit()->result();
        $query_user                = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $user_id = $query_user['id'] ?? null;

        // query bonus
        $query_today               = $this->M_user->get_today_bonus($dateNow, $user_id)->row_array();
        $query_total               = $this->M_user->get_total_bonus($user_id)->row_array();
        $query_today_fill          = $this->M_user->get_data_bydate_user('mining_user', 'datecreate', 'user_id', $dateNow, $user_id)->row_array();
        $query_total_fill          = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $user_id);
        $query_today_zenx          = $this->M_user->get_data_bydate_user('airdrop_zenx', 'datecreate', 'user_id', $dateNow, $user_id)->row_array();
        $query_total_zenx          = $this->M_user->get_total_byuser('airdrop_zenx', 'amount', 'user_id', $user_id);

        // transfer mining balance to general
        $query_transfer_fill       = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $user_id);
        $query_transfer_zenx       = $this->M_user->get_total_byuser('airdrop_zenx_transfer', 'amount', 'user_id', $user_id);

        // transfer bonus balance to general
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($user_id, 'filecoin');
        $query_transfer_bonus_zenx  = $this->M_user->get_transfer_bonus($user_id, 'zenx');

        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($user_id, 'filecoin');
        $query_withdrawal_zenx      = $this->M_user->get_total_withdrawal($user_id, 'zenx');

        $query_deposit_fil         = $this->M_user->get_sum_deposit($user_id, '1');
        $query_deposit_zenx         = $this->M_user->get_sum_deposit($user_id, '3');

        $query_row_notif = $this->M_user->row_newnotif_byuser($user_id);
        $query_new_notif = $this->M_user->show_newnotif_byuser($user_id);

        $query_total_purchase      = $this->M_user->sum_cart_byid($user_id);

        $data['title']          = 'My Home';
        $data['user']           = $query_user;
        $data['amount_notif']   = $query_row_notif;
        $data['list_notif']     = $query_new_notif;

        $today_sponsorfil = $query_today['sponsorfil'] ?? null;
        $today_sponmatchingfill = $query_today['sponmatchingfil'] ?? null;
        $today_minmatching = $query_today['minmatching'] ?? null;
        $today_minpairing = $query_today['minpairing'] ?? null;
        $today_basecampfill = $query_today['basecampfill'] ?? null;

        $today_sponsorzenx = $query_today['sponsorzenx'] ?? null;
        $today_sponmatchingzenx = $query_today['sponmatchingzenx'] ?? null;
        $today_pairingmatch_zenx = $query_today['pairingmatch'] ?? null;
        $today_binarymatch_zenx = $query_today['binarymatch'] ?? null;
        $today_bonusglobal_zenx = $query_today['bonusglobal'] ?? null;
        $today_basecamp_zenx = $query_today['basecampzenx'] ?? null;

        $total_sponsorfil = $query_total['sponsorfil'] ?? null;
        $total_sponmatchingfil = $query_total['sponmatchingfil'] ?? null;
        $total_minmatchingfil = $query_total['minmatching'] ?? null;
        $total_minpairingfil = $query_total['minpairing'] ?? null;
        $total_basecampfill = $query_total['basecampfill'] ?? null;

        $total_sponsorzenx = $query_total['sponsorzenx'] ?? null;
        $total_sponmatchingzenx = $query_total['sponmatchingzenx'] ?? null;
        $total_pairingmatch_zenx = $query_total['pairingmatch'] ?? null;
        $total_binarymatch_zenx = $query_total['binarymatch'] ?? null;
        $total_bonusglobal_zenx = $query_total['bonusglobal'] ?? null;
        $total_basecampzenx = $query_total['basecampzenx'] ?? null;

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $data['cart']                = $this->M_user->show_home_withsumpoint($user_id)->row_array();
                $data['banner1']             = $this->M_user->get_banner_home(1);
                $data['banner2']             = $this->M_user->get_banner_home(2);
                $data['today_fil']           = $today_sponsorfil + $today_sponmatchingfill + $today_minmatching + $today_minpairing + $today_basecampfill;
                $data['today_zenx']           = $today_sponsorzenx + $today_sponmatchingzenx + $today_pairingmatch_zenx + $today_binarymatch_zenx + $today_bonusglobal_zenx + $today_basecamp_zenx;
                $data['total_fil']           = $total_sponsorfil + $total_sponmatchingfil + $total_minmatchingfil + $total_minpairingfil + $total_basecampfill;
                $data['total_zenx']           = $total_sponsorzenx + $total_sponmatchingzenx + $total_pairingmatch_zenx + $total_binarymatch_zenx + $total_bonusglobal_zenx + $total_basecampzenx;
                $data['balance_fil']         = $data['total_fil'] - $query_transfer_bonus_fill['amount'];
                $data['balance_zenx']         = $data['total_zenx'] - $query_transfer_bonus_zenx['amount'];

                $data['mining_fil_today']    = isset($query_today_fill['amount']) ? $query_today_fill['amount'] : 0;
                $data['mining_fil_total']    = isset($query_total_fill['amount']) ? $query_total_fill['amount'] : 0;
                $data['mining_fil_balance']  = $query_total_fill['amount'] - $query_transfer_fill['amount'];
                $data['mining_zenx_today']    = isset($query_today_zenx['amount']) ? $query_today_zenx['amount'] : 0;
                $data['mining_zenx_total']    = isset($query_total_zenx['amount']) ? $query_total_zenx['amount'] : 0;
                $data['mining_zenx_balance']  = $query_total_zenx['amount'] - $query_transfer_zenx['amount'];

                $data['market_price']        = $this->M_user->get_price_coin()->row_array();

                $data['general_balance_fil'] = $query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount'] + $query_deposit_fil['coin'] - $query_withdrawal_fil['amount'] - $query_total_purchase['fill'];
                $data['general_balance_zenx'] = $query_transfer_zenx['amount'] + $query_transfer_bonus_zenx['amount'] + $query_deposit_zenx['coin'] - $query_total_purchase['zenx'] - $query_withdrawal_zenx['amount'];

                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/index', $data);
                $this->load->view('templates/user_footer');
            } elseif ($this->session->userdata('role_id') == '1') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/index', $data);
                $this->load->view('templates/user_footer');
            }
        } else {
            redirect('auth');
        }
    }

    public function package()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['package_filecoin']   = $this->M_user->show_package('1');
        $data['package_mtmcoin']    = $this->M_user->show_package('2');
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_purchase', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function packageTour()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_purchase_tour', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageKoreaVIP()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageKoreaVVIP()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vvip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageKoreaGoldVVIP()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/gold_vvip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function gyeongbokPalace()
    {
        $this->_unset_payment();

        $data['title']  = 'Gyeongbok Palace';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/gyeongbok_palace', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    private function _unset_payment()
    {
        $this->session->unset_userdata('purchase');
        $this->session->unset_userdata('cart');
    }

    public function fil()
    {
        $data_id        = $this->uri->segment(3);
        $data_package   = $this->M_user->get_package_byid($data_id);
        $id_package     = $data_package['id'];

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_deposit_fil         = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase      = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']              = 'Terms and Conditions';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx'] = $query_deposit_zenx['coin'] - $query_total_purchase['zenx'];

        $this->session->set_userdata('purchase', $id_package);

        $data['fil'] = $data_package['fil'];
        $data['price_fil'] = $data_package['price_fil'];
        $data['price_mtm'] = $data_package['price_mtm'];
        $data['price_zenx'] = $data_package['price_zenx'];

        // $deposit = $this->_count_deposit($query_user['id']);

        // $data['balance'] = $deposit;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/term_condition', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function purchase()
    {
        $data_id        = $this->uri->segment(3);
        $data_package   = $this->M_user->get_package_byid($data_id);
        $id_package     = $data_package['id'];

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');

        $data['title']              = 'Terms and Conditions';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'];

        $this->session->set_userdata('purchase', $id_package);

        $data['fil'] = $data_package['fil'];

        // $deposit = $this->_count_deposit($query_user['id']);

        // $data['balance'] = $deposit;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            // if($deposit<$data_package['fil'])
            // {
            //     $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Your balance is not enough to buy this package! Your balance is '.$deposit.' FIL</div>');
            //     redirect ('user/package');
            // }
            // else
            // {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/term_condition', $data);
            $this->load->view('templates/user_footer');
            // }

        } else {
            redirect('auth');
        }
    }

    // private function _count_deposit($userid)
    // {
    //     $query_deposit = $this->db->select_sum('coin')->where(['is_confirm' => 1, 'user_id' => $userid])->get('deposit')->row();
    //     $qty_deposit = $query_deposit->coin;

    //     $query_cart = $this->db->select_sum('fill')->where(['is_payment' => 1, 'user_id' => $userid])->get('cart')->row();
    //     $qty_cart = $query_cart->fill;

    //     $deposit = $qty_deposit-$qty_cart;

    //     return $deposit;
    // }

    public function cart()
    {

        $user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($user['id'], 'filecoin');
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $user['id']);
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($user['id'], 'mtm');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($user['id'], 'mtm');
        $query_deposit_fil         = $this->M_user->get_sum_deposit($user['id'], '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($user['id'], '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($user['id'], '3');
        $query_total_purchase      = $this->M_user->sum_cart_byid($user['id']);

        $data['title']                  = 'Terms and Conditions';
        $data['user']                   = $user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['general_balance_fil']    = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm']    = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx']   =  $query_deposit_zenx['coin'] - $query_total_purchase['zenx'];

        // $query_deposit = $this->db->select_sum('coin')->where(['is_confirm' => 1, 'user_id' => $user['id']])->get('deposit')->row();
        // $data['balance'] = $query_deposit->coin;

        if (empty($data['cart']['name'])) {
            $this->form_validation->set_rules('sponsor', 'Sponsor ID', 'required|trim');
            $this->form_validation->set_rules('position', 'Position ID', 'required|trim');
            $this->form_validation->set_rules('line', 'Line', 'required', [
                'required' => 'Please select line'
            ]);
        }

        $this->form_validation->set_rules('accept_terms', '...', 'callback_accept_terms');
        $this->form_validation->set_rules('agree_term', '...', 'callback_agree_term');
        $this->form_validation->set_rules('agree_privacy', '...', 'callback_agree_privacy');

        $this->session->set_userdata('purchase', $this->input->post('data_purchase'));

        $data_package   = $this->M_user->get_package_byid($this->session->userdata('purchase'));

        $data['fil']        = $data_package['fil'];
        $data['price_fil']  = $data_package['price_fil'];
        $data['price_mtm']  = $data_package['price_mtm'];
        $data['price_zenx'] = $data_package['price_zenx'];

        //$check_matching_id = $this->db->get_where('user', ['username' => $this->input->post('matching')])->row_array();
        //$check_sponsor_id  = $this->db->get_where('user', ['username' => $this->input->post('sponsor')])->row_array();
        //$check_position_id = $this->db->get_where('user', ['username' => $this->input->post('position')])->row_array();
        //$check_belong_matching = $this->db->get_where('cart', ['user_id' => $check_sponsor_id['id']])->row_array();

        $check_sponsor_id   = $this->M_user->get_member_byusername($this->input->post('sponsor'));

        $sponsorid_notnull = $check_sponsor_id['user_id'] ?? null;

        $check_position_id  = $this->M_user->get_member_byusername($this->input->post('position'));
        $query_matching     = $this->M_user->get_mactching_id($sponsorid_notnull);

        // if (isset($_POST['buy'])) {
        //     $balance = explode(' ', trim($this->input->post('balance')))[0];
        //     $price = explode(' ', trim($this->input->post('price')))[0];
        //     var_dump($balance);
        //     var_dump($price);
        //     die;
        // }

        if ($this->form_validation->run() == false) {
            $data['checked1'] = $this->input->post('accept_terms');
            $data['checked2'] = $this->input->post('agree_term');
            $data['checked3'] = $this->input->post('agree_privacy');

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/term_condition', $data);
            $this->load->view('templates/user_footer');
        } else {
            if (!empty($this->input->post('data_purchase'))) {
                // if($this->input->post('matching') == '' && $this->input->post('sponsor') == '' && $this->input->post('position') == '')
                // {
                //     $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $this->input->post('data_fil'), '0', '0', '0', '');
                // }
                // elseif($this->input->post('matching') == '' && $this->input->post('sponsor') != '' && $this->input->post('position') != '')
                // {
                //     $check_line = $this->db->get_where('cart', ['sponsor_id' => $check_position_id['id'], 'line' => $this->input->post('line')])->row_array();

                //     if($check_line)
                //     {
                //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Line '.$this->input->post('line').' for this Position ID is already filled</div>');

                //         $this->load->view('templates/user_header', $data);
                //         $this->load->view('templates/user_sidebar', $data);
                //         $this->load->view('templates/user_topbar', $data);
                //         $this->load->view('user/term_condition', $data);
                //         $this->load->view('templates/user_footer');
                //     }
                //     else
                //     {
                //         $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $this->input->post('data_fil'), '0', $check_sponsor_id['id'], $check_position_id['id'], $this->input->post('line'));
                //     }
                // }
                // elseif($check_matching_id['id'] == $check_position_id['id'] || $check_matching_id['id'] == $check_sponsor_id['id'])
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Matching ID</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // elseif($check_matching_id['id'] != $check_belong_matching['position_id'])
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Matching ID has no relationship with Sponsor ID</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // else
                // {
                // if($check_matching_id)
                // {

                //komentar start
                if (empty($data['cart']['name'])) {
                    if ($check_sponsor_id) {
                        if ($check_position_id) {
                            $check_line = $this->M_user->check_line($check_position_id['user_id'], $this->input->post('line'));

                            if ($check_line) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Line ' . $this->input->post('line') . ' for this Position ID is already filled</div>');

                                $this->load->view('templates/user_header', $data);
                                $this->load->view('templates/user_sidebar', $data);
                                $this->load->view('templates/user_topbar', $data);
                                $this->load->view('user/term_condition', $data);
                                $this->load->view('templates/user_footer');
                            } else {
                                if ($this->input->post('cointype') == 'fil') {
                                    $dataBalance = $data['general_balance_fil'];
                                    $dataPrice = $data['price_fil'];
                                } elseif ($this->input->post('cointype') == 'mtm') {
                                    $dataBalance = $data['general_balance_mtm'];
                                    $dataPrice = $data['price_mtm'];
                                } elseif ($this->input->post('cointype') == 'zenx') {
                                    $dataBalance = $data['general_balance_zenx'];
                                    $dataPrice = $data['price_zenx'];
                                }

                                if ($dataBalance < $dataPrice) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your balance is low. Please deposit first.</div>');

                                    $this->load->view('templates/user_header', $data);
                                    $this->load->view('templates/user_sidebar', $data);
                                    $this->load->view('templates/user_topbar', $data);
                                    $this->load->view('user/term_condition', $data);
                                    $this->load->view('templates/user_footer');
                                } else {
                                    $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $dataPrice, $query_matching['sponsor_id'], $check_sponsor_id['user_id'], $check_position_id['user_id'], $this->input->post('line'), $this->input->post('cointype'));
                                }
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Position ID</div>');

                            $this->load->view('templates/user_header', $data);
                            $this->load->view('templates/user_sidebar', $data);
                            $this->load->view('templates/user_topbar', $data);
                            $this->load->view('user/term_condition', $data);
                            $this->load->view('templates/user_footer');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Sponsor ID</div>');

                        $this->load->view('templates/user_header', $data);
                        $this->load->view('templates/user_sidebar', $data);
                        $this->load->view('templates/user_topbar', $data);
                        $this->load->view('user/term_condition', $data);
                        $this->load->view('templates/user_footer');
                    }
                } else {
                    if ($this->input->post('cointype') == 'fil') {
                        $dataBalance = $data['general_balance_fil'];
                        $dataPrice = $data['price_fil'];
                    } elseif ($this->input->post('cointype') == 'mtm') {
                        $dataBalance = $data['general_balance_mtm'];
                        $dataPrice = $data['price_mtm'];
                    } elseif ($this->input->post('cointype') == 'zenx') {
                        $dataBalance = $data['general_balance_zenx'];
                        $dataPrice = $data['price_zenx'];
                    }

                    if ($dataBalance < $dataPrice) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your balance is low. Please deposit first.</div>');

                        $this->load->view('templates/user_header', $data);
                        $this->load->view('templates/user_sidebar', $data);
                        $this->load->view('templates/user_topbar', $data);
                        $this->load->view('user/term_condition', $data);
                        $this->load->view('templates/user_footer');
                    } else {
                        $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $dataPrice, 0, 0, 0, '', $this->input->post('cointype'));
                    }
                }

                //komentar end

                // }
                // else
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Matching ID not found</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // }
            } else {
                redirect('user/package');
            }
        }
    }

    private function _insert_cart($dataPurchase, $userId, $price, $matchingId, $sponsorId, $positionId, $line, $typeCoin)
    {
        if ($typeCoin == 'fil') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'fill' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        } elseif ($typeCoin == 'mtm') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'mtm' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        } elseif ($typeCoin == 'zenx') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'zenx' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        }

        $last_cartid = $this->M_user->insert_cart('cart', $data_insert);

        /**Bonus sponsor */
        $bonus = $this->_sponsorBonus($last_cartid);

        /**Level FM */
        $this->_insertFm($last_cartid);

        //Excess Bonus
        $this->_insert_Excess($userId);

        $this->session->set_userdata('cart', $last_cartid);
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Your package purchase was successful</div>');
        redirect('user/history');
    }

    private function _insert_Excess($userId)
    {
        $query_excess = $this->M_user->get_all_excess($userId);
        
        if(!empty($query_excess))
        {
            $query_conversion_zenx  = $this->M_user->get_last_data('market_price', 'convert', 'DESC');
            $zenx_price   = $query_conversion_zenx['convert'];
            foreach($query_excess as $row)
            {
                $limit_bonus        = $this->_check_limit_bonus($userId, $row->zenx, $zenx_price);
                
                $limit_count_zenx   = $limit_bonus;
                $excess_bonus       = $row->zenx - $limit_count_zenx;    
                
                //ketika limit 0 tidak jalan lagi
                if($limit_count_zenx == 0)
                {
                    break;
                }
                else
                {
                    //ketika limit tidak 0 bonus masuk, excess bonus update
                    if($row->note == 'bonus sponsor')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => 0,
                            'zenx' => $limit_count_zenx,
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus', $data);
                        
                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus sponsor matching')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => 0,
                            'zenx' => $limit_count_zenx,
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus_sm', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus pairing')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'zenx' => $limit_count_zenx,
                            'set_amount' => '0',
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus_maxmatching', $data);

                        
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'airdrop zenx')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'amount' => $limit_count_zenx,
                            'box' => $row->box,
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('airdrop_zenx', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus pairing matching')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'user_sponsor' => $row->user_sponsor,
                            'zenx' => $limit_count_zenx,
                            'generation' => $row->generation,
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus_binarymatch', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus global')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'zenx' => $limit_count_zenx,
                            'level_fm' => $row->level_fm,
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus_global', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus basecamp')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'zenx' => $limit_count_zenx,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => '0',
                            'type' => '1',
                            'status' => '1',
                            'datecreate' => time()
                        ];

                        $this->M_user->insert_data('bonus_basecamp', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                }
            }
            return true;  
        }

        // $query_excess = $this->M_user->get_excess_bonus($userId)->row_array();

        // if(!empty($query_excess['zenx']))
        // {
        //     $query_conversion_zenx  = $this->M_user->get_last_data('market_price', 'convert', 'DESC');
        //     $zenx_price             = $query_conversion_zenx['convert'];

        //     $limit_bonus            = $this->_check_limit_bonus($userId, $query_excess['zenx'], $zenx_price);
        //     $limit_count            = $limit_bonus;
            
        //     //insert airdrop
        //     $data_airdrop = [
        //         'user_id' => $userId,
        //         'cart_id' => '0',
        //         'amount' => $limit_count,
        //         'box'   => '0',
        //         'note' => 'Zenx income from Excess Bonus',
        //         'datecreate' => time()
        //     ];
    
        //     $insert_airdrop = $this->M_user->insert_data('airdrop_zenx', $data_airdrop);
    
        //     //minus excess bonus
        //     if($insert_airdrop)
        //     {
        //         $excess = '-'.$limit_count;
    
        //         $data_excess = [
        //             'user_id' => $userId,
        //             'type_bonus' => '0',
        //             'zenx' => $excess,
        //             'cart_id' => '0',
        //             'code_bonus' => '0',
        //             'user_sponsor' => '0',
        //             'generation' => '0',
        //             'level_fm' => '0',
        //             'note' => 'transfer to airdrop',
        //             'datecreate' => time()
        //         ];
    
        //         $insert_airdrop = $this->M_user->insert_data('excess_bonus', $data_excess);
    
        //         return true;
        //     }
        // }
    }

    public function _update_excess($excess_bonus, $id)
    {
        //ketika excess bonus tidak sama dengan 0 update excess bonus
        if($excess_bonus != 0)
        {
            $data_update = [
                'zenx' => $excess_bonus
            ];

            $this->M_user->update_data_byid('excess_bonus', $data_update, 'id', $id);
        }
        else
        {
            //ketika excess = 0, update excess keterangan excess has transfer
            $data_update = [
                'zenx' => $excess_bonus,
                'note' => 'excess has transfer to bonus'
            ];

            $this->M_user->update_data_byid('excess_bonus', $data_update, 'id', $id);
        }

        return 0;
    }

    /**Add bonus sponsor */
    private function _sponsorBonus($id)
    {
        $check_bonus = $this->M_user->check_bonus_byid($id);

        if ($check_bonus) {
            return false;
        } else {
            $datapayment    = $this->M_user->get_bonus_amount($id);
            $user_id        = $datapayment['user_id'] ?? null;

            $query_top_user = $this->M_user->get_cart_notnullsponsor($user_id);
            $sponsor_id     = $query_top_user['sponsor_id'] ?? null;
            $matching_id    = $query_top_user['matching_id'] ?? null;

            if ($datapayment['price'] != 0) {
                $count_bonus = ($datapayment['price'] * $datapayment['amount_sp']) / 100;
                $query_basecamp = $this->M_user->get_camp_fm($sponsor_id);

                if ($matching_id == 0) {
                    $count_sponsor  = $count_bonus / 2;

                    $query_conversion_zenx = $this->M_user->get_last_data('market_price', 'convert', 'DESC');
                    $zenx_price            = $query_conversion_zenx['convert'];

                    $count_zenx      = $count_sponsor * $zenx_price;

                    $limit_bonus        = $this->_check_limit_bonus($sponsor_id, $count_zenx, $zenx_price);

                    $excess_bonus       = $count_zenx - $limit_bonus;

                    $limit_count_zenx    = $limit_bonus;

                    $data_excess_sponsor = [
                        'user_id' => $sponsor_id,
                        'type_bonus' => '1',
                        'zenx' => $excess_bonus,
                        'cart_id' => $id,
                        'code_bonus' => $datapayment['code'],
                        'user_sponsor' => '0',
                        'generation' => '0',
                        'note' => 'bonus sponsor',
                        'datecreate' => time()
                    ];

                    $this->M_user->insert_data('excess_bonus', $data_excess_sponsor);

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $sponsor_id,
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'zenx' => $limit_count_zenx,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) {

                        if ($query_basecamp['is_camp'] == 1) {
                            if ($query_basecamp['fm'] == 'FM5') {
                                $additionalBonus = 2;
                            } elseif ($query_basecamp['fm'] == 'FM6') {
                                $additionalBonus = 2.5;
                            } elseif ($query_basecamp['fm'] == 'FM7') {
                                $additionalBonus = 3;
                            } elseif ($query_basecamp['fm'] == 'FM8') {
                                $additionalBonus = 3.5;
                            }

                            $count_bonus_basecamp = ($datapayment['price'] * $additionalBonus) / 100;

                            $bonus_basecamp_zenx = $count_bonus_basecamp * $zenx_price;

                            $data_insert_basecamp = [
                                'cart_id' => $id,
                                'user_id' => $sponsor_id,
                                'code_bonus' => $datapayment['code'],
                                'zenx' => $bonus_basecamp_zenx,
                                'type' => '1',
                                'status' => '0',
                                'datecreate' => time()
                            ];

                            $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);

                        }


                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $query_conversion_zenx = $this->M_user->get_last_data('market_price', 'convert', 'DESC');
                    $zenx_price            = $query_conversion_zenx['convert'];

                    $count_sponsor_matching = (($count_bonus * $datapayment['amount_sm']) / 100) / 2;
                    $count_sm_zenx          = $count_sponsor_matching * $zenx_price;

                    $count_sponsor          = ($count_bonus) / 2;
                    $count_zenx             = $count_sponsor * $zenx_price;

                    $limit_bonus    = $this->_check_limit_bonus($sponsor_id, $count_zenx, $zenx_price);
                    $excess_bonus   = $count_zenx - $limit_bonus;

                    $data_excess_sponsor = [
                        'user_id' => $sponsor_id,
                        'type_bonus' => '1',
                        'zenx' => $excess_bonus,
                        'cart_id' => $id,
                        'code_bonus' => $datapayment['code'],
                        'user_sponsor' => '0',
                        'generation' => '0',
                        'note' => 'bonus sponsor',
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('excess_bonus', $data_excess_sponsor);

                    $limit_count_zenx = $limit_bonus;

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $sponsor_id,
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'zenx' => $limit_count_zenx,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) {
                        $limit_bonus_sm         = $this->_check_limit_bonus($matching_id, $count_sm_zenx, $zenx_price);
                        $excess_bonus_sm        = $count_sm_zenx - $limit_bonus_sm;
                        $limit_count_sm_zenx    = $limit_bonus_sm;

                        $data_excess_sm = [
                            'user_id' => $matching_id,
                            'type_bonus' => '2',
                            'zenx' => $excess_bonus_sm,
                            'cart_id' => $id,
                            'code_bonus' => $datapayment['code'],
                            'user_sponsor' => '0',
                            'generation' => '0',
                            'note' => 'bonus sponsor matching',
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('excess_bonus', $data_excess_sm);

                        $data_sm = [
                            'user_id' => $matching_id,
                            'cart_id' => $id,
                            'code_bonus' => $datapayment['code'],
                            'filecoin' => $count_sponsor_matching,
                            'zenx' => $limit_count_sm_zenx,
                            'datecreate' => time()
                        ];

                        $insert_bonus_sm = $this->M_user->insert_data('bonus_sm', $data_sm);

                        if ($insert_bonus_sm) {
                            if ($query_basecamp['is_camp'] == 1) {
                                if ($query_basecamp['fm'] == 'FM5') {
                                    $additionalBonus = 2;
                                } elseif ($query_basecamp['fm'] == 'FM6') {
                                    $additionalBonus = 2.5;
                                } elseif ($query_basecamp['fm'] == 'FM7') {
                                    $additionalBonus = 3;
                                } elseif ($query_basecamp['fm'] == 'FM8') {
                                    $additionalBonus = 3.5;
                                }

                                $count_bonus_basecamp = ($datapayment['price'] * $additionalBonus) / 100;

                                $bonus_basecamp_zenx = $count_bonus_basecamp * $zenx_price;

                                $data_insert_basecamp = [
                                    'cart_id' => $id,
                                    'user_id' => $sponsor_id,
                                    'code_bonus' => $datapayment['code'],
                                    'zenx' => $bonus_basecamp_zenx,
                                    'type' => '1',
                                    'status' => '0',
                                    'datecreate' => time()
                                ];

                                $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);

                            }
                            return true;
                        }

                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    
    private function _check_limit_bonus($user_id, $count_zenx, $zenx_price)
    {
        $query_top = $this->M_user->get_user_toplevel($user_id);
        $user_top = $query_top['id'] ?? null;

        if($user_id == $user_top)
        {
            return $count_zenx;
        }
        else
        {
            $query_box      = $this->M_user->get_totalbox_byid($user_id);
            $query_total    = $this->M_user->get_total_bonus($user_id)->row_array();
            $query_airdrop  = $this->M_user->sum_airdrop_byuser($user_id);
    
            $box    = $query_box['fil']*$zenx_price;
            $limit  = ($box*300)/100;
    
            $total_bonus = $query_airdrop['amount']+$query_total['sponsorzenx']+$query_total['sponmatchingzenx']+$query_total['pairingmatch']+$query_total['binarymatch']+$query_total['bonusglobal']+$query_total['basecampzenx']+$count_zenx;
    
            if($total_bonus <= $limit)
            {
                return $count_zenx;
            }
            else
            {
                $total_now = $total_bonus - $count_zenx;
    
                if($total_now < $limit)
                {
                    $bonus_new = $limit - $total_now;
    
                    if($bonus_new < $count_zenx)
                    {
                        $result = $bonus_new;
                    }
                    else
                    {
                        $result = $count_zenx;
                    }
                }
                else
                {
                    $result = 0;
                }
    
                return $result;
            }
        }
    }

    private function _insertFm($id)
    {
        $data_user = $this->M_user->get_cart_byid($id);

        $data_insert = [
            'user_id' => $data_user['user_id'],
            'fm' => 'FM',
            'datecreate' => time()
        ];

        $check_data = $this->M_user->get_data_byid('level_fm', 'user_id', $data_user['user_id']);

        if (empty($check_data['id'])) {
            $insert     = $this->M_user->insert_data('level_fm', $data_insert);
            return true;
        }else{
            return true;
        }
    }

    public function payment()
    {
        if (!empty($this->uri->segment(4))) {
            $this->M_user->update_data_byid('notifi', ['is_show' => 1], 'id', $this->uri->segment(4));
        }

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['title']              = 'Package Payment';

        if (!empty($this->uri->segment(3))) {
            $data['cart_pay']               = $this->M_user->get_cart_byid($this->uri->segment(3));
            $this->session->set_userdata('cart', $this->uri->segment(3));
        } else {
            $data['cart_pay']               = $this->M_user->get_cart_byid($this->session->userdata('cart'));
        }

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        $this->form_validation->set_rules('txid', 'TXID', 'required|is_unique[txid.txid]', [
            'is_unique' => 'TXID not valid'
        ]);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            if (!empty($this->session->userdata('cart'))) {
                if ($this->form_validation->run() == false) {
                    $this->load->library('ciqrcode');
                    $config['cacheable']    = true;
                    $config['cachedir']     = 'assets/';
                    $config['errorlog']     = 'assets/';
                    $config['imagedir']     = 'assets/img/';
                    $config['quality']      = true;
                    $config['size']         = '1024';
                    $config['black']        = array(224, 255, 255);
                    $config['white']        = array(70, 130, 180);
                    $this->ciqrcode->initialize($config);

                    $image_name = 'new_qrcode.png';

                    $params['data'] = 'f1fzgcduywwfq7dqkahiwztsbdzv3g6j2hxjhgzey';
                    $params['level'] = 'H';
                    $params['size'] = 10;
                    $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
                    $this->ciqrcode->generate($params);

                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/payment', $data);
                    $this->load->view('templates/user_footer');
                } else {
                    $txid    = $this->input->post('txid', true);
                    $cartid  = $this->input->post('cartid', true);

                    $data_txid = [
                        'cart_id'       => $cartid,
                        'txid'          => $txid,
                        'datecreate'    => time(),
                    ];

                    $insert = $this->M_user->insert_data('txid', $data_txid);

                    if ($insert) {
                        $update_cart = $this->M_user->update_payment('3', $cartid);

                        if ($update_cart) {
                            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Success! Your payment has been received, wait for the payment to be confirmed!</div>');
                            redirect('user/history');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Failed to save your payment!</div>');
                            redirect('user/history');
                        }
                    } else {
                        redirect('user/payment');
                    }
                }
            } else {
                redirect('user/package');
            }
        } else {
            redirect('auth');
        }
    }

    public function cancelPayment()
    {
        if (!empty($this->session->userdata('cart'))) {
            $this->M_user->update_payment_status('2', $this->session->userdata('cart'));

            redirect('user/package');
        } else {
            redirect('user/package');
        }
    }

    public function accept_terms()
    {
        if (isset($_POST['accept_terms'])) return true;
        $this->form_validation->set_message('accept_terms', 'Must Accept this Terms and Conditions');
        return false;
    }

    public function agree_term()
    {
        if (isset($_POST['agree_term'])) return true;
        $this->form_validation->set_message('agree_term', 'Must Agree Terms and Conditions');
        return false;
    }

    public function agree_privacy()
    {
        if (isset($_POST['agree_privacy'])) return true;
        $this->form_validation->set_message('agree_privacy', 'Must Agree Privacy Policy');
        return false;
    }

    public function history()
    {
        if (!empty($this->uri->segment(3))) {
            $this->M_user->update_data_byid('notifi', ['is_show' => 1], 'id', $this->uri->segment(3));
        }

        $user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);

        $data['user']               = $user;
        $data['title']              = 'Payment History';
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($user['id']);
        $datacart_updatedate        = $data['cart']['update_date'] ?? null;

        $mining_payment = date('Y-m-d', $datacart_updatedate);

        $date_fil = new DateTime($mining_payment);
        $date_fil->modify('45 days');
        $data['fil_startpayment'] = $date_fil->format('d/m/Y');
        $date_fil->modify('1100 days');
        $data['fil_endpayment'] = $date_fil->format('d/m/Y');

        $date_mtm = new DateTime($mining_payment);
        $date_mtm->modify('1 week');
        $data['mtm_startpayment'] = $date_mtm->format('d/m/Y');
        $date_mtm->modify('540 days');
        $data['mtm_endpayment'] = $date_mtm->format('d/m/Y');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/payment_history', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function deposit()
    {
        $user               = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);

        $data['user']               = $user;
        $data['title']              = 'Deposit';
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['wallet_address']     = $this->M_user->walletAddress()->row_array();

        if (!empty($this->uri->segment(4))) {
            $data['id_deposit']       = $this->uri->segment(4);
            $data['id_notif']         = $this->uri->segment(5);
        } else {
            $data['id_deposit']       = '';
            $data['id_notif']       = '';
        }

        $this->form_validation->set_rules('txid', 'TXID', 'required|trim|is_unique[deposit.txid]', [
            'is_unique' => 'TXID not valid'
        ]);
        $this->form_validation->set_rules('coinqty', 'Coin quantity', 'required|numeric');

        if ($this->uri->segment(3) == '2') {
            $data['currentTab'] = 'mtm';
        } elseif ($this->uri->segment(3) == '3') {
            $data['currentTab'] = 'zenx';
        } else {
            $data['currentTab'] = 'fil';
        }

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            if ($this->form_validation->run() == false) //check validation
            {
                $this->load->library('ciqrcode');
                $config['cacheable']    = true;
                $config['cachedir']     = 'assets/';
                $config['errorlog']     = 'assets/';
                $config['imagedir']     = 'assets/img/';
                $config['quality']      = true;
                $config['size']         = '1024';
                $config['black']        = array(224, 255, 255);
                $config['white']        = array(70, 130, 180);
                $this->ciqrcode->initialize($config);

                $image_name     = 'wallet_fil_qr.png';
                $image_name2    = 'wallet_mtm_qr.png';
                $image_name3    = 'wallet_zenx_qr.png';

                $params['data'] = $data['wallet_address']['filecoin'];
                $params['level'] = 'H';
                $params['size'] = 10;
                $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
                $this->ciqrcode->generate($params);

                $params2['data'] = $data['wallet_address']['mtm'];
                $params2['level'] = 'H';
                $params2['size'] = 10;
                $params2['savename'] = FCPATH . $config['imagedir'] . $image_name2;
                $this->ciqrcode->generate($params2);

                $params3['data'] = $data['wallet_address']['zenx'];
                $params3['level'] = 'H';
                $params3['size'] = 10;
                $params3['savename'] = FCPATH . $config['imagedir'] . $image_name3;
                $this->ciqrcode->generate($params3);


                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/deposit', $data);
                $this->load->view('templates/user_footer');
            } else {
                if (!empty($this->input->post('iddeposit'))) {
                    //update deposit
                    $data_update = [
                        'txid' => htmlspecialchars($this->input->post('txid', true)),
                        'coin' => $coin = htmlspecialchars($this->input->post('coinqty', true)),
                        'note' => ''
                    ];

                    $update_cart = $this->M_user->update_data_byid('deposit', $data_update, 'id', $this->input->post('iddeposit'));

                    //update notification
                    $data_notif = [
                        'is_show' => 1
                    ];

                    $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $this->input->post('id_notif'));

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Congratulation! your deposit has been update. Wait until confirmation by admin</div>');
                    redirect('user/deposit');
                } else {
                    //insert deposit
                    $data_insert = [
                        'user_id' => $user['id'],
                        'txid' => htmlspecialchars($this->input->post('txid', true)),
                        'coin' => $coin = htmlspecialchars($this->input->post('coinqty', true)),
                        'type_coin' => htmlspecialchars($this->input->post('typecoin', true)),
                        'datecreate' => time()
                    ];

                    $this->db->insert('deposit', $data_insert);

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Congratulation! your deposit has been create. Wait until confirmation by admin</div>');
                    redirect('user/deposit');
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function bonusList()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Bonus';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/index', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    //Bonus Sponsor 
    public function sponsor()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_sponsor_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_byid($query_user['id'], 'bonus sponsor');

        $data['title']              = 'Bonus Recommended';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['excess_bonus']       = $this->M_user->get_excess_sponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['userClass']          = $this;
        $data['total_excess']       = $query_total_excess['zenx'];
        $data['total_zenx']         = $query_total['zenx'];
        $data['total_fil']          = $query_total['filecoin'];

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/sponsor', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    public function sponsorMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_sponsormatch_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_byid($query_user['id'], 'bonus sponsor matching');

        $data['title']              = 'Bonus Recommended Matching';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['excess_bonus']       = $this->M_user->get_excess_sponsor_matching($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['total_excess']       = $query_total_excess['zenx'];
        $data['total_fil']          = $query_total['filecoin'];
        $data['total_zenx']         = $query_total['zenx'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/sponsor_matching', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    private function _color_network($point)
    {
        if ($point < 3) {
            $color = '#FFD11A';
        } elseif ($point >= 3 && $point < 9) {
            $color = '#119A48';
        } elseif ($point >= 9 && $point < 15) {
            $color = '#4169B2';
        } elseif ($point >= 15 && $point < 30) {
            $color = '#874D9E';
        } elseif ($point >= 30 && $point < 60) {
            $color = '#EF3D39';
        } elseif ($point >= 60 && $point < 120) {
            $color = '#8DC63F';
        } elseif ($point >= 120 && $point < 300) {
            $color = '#EB9123';
        } elseif ($point >= 300 && $point < 540) {
            $color = '#46C2CA';
        } elseif ($point >= 540) {
            $color = '#CA4291';
        }

        return $color;
    }

    public function network()
    {
        $this->_unset_payment();

        $data['title'] = 'Network';

        if ($this->uri->segment(3) != '') {
            $id = $this->uri->segment(3);

            $query_user    = $this->M_user->get_user_byid($id);
        } else {
            $query_user    = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        }

        $limitLevel     = $this->_countLimitLevel(0, $query_user['id']);
        
        $idLeft         = $this->countIDL($query_user['id']);
        $idRight        = $this->countIDR($query_user['id']);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['network']            = $this->_showNetwork($query_user['id'], $query_user['country_code'], $query_user['username']);
        $sidebar['user']            = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['limitLevel']         = $limitLevel;

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/network', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    private function _showNetwork($id, $countryCode, $username)
    {
        $endLoop        = 10;
        $query_position = $this->M_user->get_network_byposition($id);
        $package        = $this->M_user->get_box_fm($id)->row_array();
        $query_box      = $this->M_user->sumPackage($id);
        $balancePoint   = $this->balance_point($id);

        $pointTodayL    = $this->countPointTodayL($id);
        $pointTodayR    = $this->countPointTodayR($id);
        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);
        $package_fm     = $package['fm'] ?? null;
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);
        
        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }

        if ($balancePoint) 
        {
            $balance_a = $balancePoint['balance_a'] + $pointTodayL;
            $balance_b = $balancePoint['balance_b'] + $pointTodayR;
        } else {
            if($pointTodayL != 0)
            {
                $balance_a = $pointTodayL;
            }
            else
            {
                $balance_a = $pointTodayL+$this->countPositionL($id);
            }

            if($pointTodayR != 0)
            {
                $balance_b = $pointTodayR;
            }
            else
            {
                $balance_b = $pointTodayR+$this->countPositionR($id);
            }
        }

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden; transform:scale(' . $scale . ')">';
        $output .=    '<div class="item" style="border: 7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="flag">
                            <h1 class="text-uppercase name-network">' . $username . '</h1>
                            <p>' . $package_fm . '</p>
                            <div class="d-flex  justify-content-center align-content-center align-items-center position-relative">
                                <div class="text-right">
                                    <p>(' . $idLeft . ' ID) left</p>
                                    <p style="color:white">' . $balance_a . '&nbsp;(' . $this->countPositionL($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color:white">+ ' . $pointTodayL . '</p>
                                </div>
                                <div class="line"></div>
                                <div class="text-left">
                                    <p>right (' . $idRight . ' ID)</p>
                                    <p style="color: white">' . $balance_b . '&nbsp;(' . $this->countPositionR($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color: white">+ ' . $pointTodayR . '</p>
                                </div>
                            </div>
                            <p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
                            <button id="'.$id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';

                        $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';

        // if (count($query_position) != '') {
        //     $output .= '<ul>';

        //     foreach ($query_position as $row_position) {
        //         $countLeft      = $this->countPositionL($row_position->user_id);
        //         $countRight     = $this->countPositionR($row_position->user_id);
        //         $balancePoint   = $this->balance_point($row_position->user_id);
        //         // $increaseLeft   = $this->countPositionL($row_position->user_id) - $this->increasePoint($row_position->user_id, 'L');
        //         // $increaseRight  = $this->countPositionR($row_position->user_id) - $this->increasePoint($row_position->user_id, 'R');
        //         $pointTodayL    = $this->countPointTodayL($row_position->user_id);
        //         $pointTodayR    = $this->countPointTodayR($row_position->user_id);
        //         $idLeft         = $this->countIDL($row_position->user_id);
        //         $idRight        = $this->countIDR($row_position->user_id);
        //         $query_box      = $this->M_user->sumPackage($row_position->user_id);
        //         $package_name   = $query_box['point'] ?? null;
        //         $package_color  = $this->_color_network($package_name);

        //         if ($balancePoint) {
        //             // $balance_a = $balancePoint['amount_left'] + $increaseLeft;
        //             // $balance_b = $balancePoint['amount_right'] + $increaseRight;
        //             $balance_a = $balancePoint['balance_a'] + $pointTodayL;
        //             $balance_b = $balancePoint['balance_b'] + $pointTodayR;
        //         } else {
        //             $balance_a = $countLeft;
        //             $balance_b = $countRight;
        //         }


        //         $output .=    '<li>';
        //         $output .=      '<a href="' . base_url('user/network/') . $row_position->user_id . '">
        //                             <div class="item" style="border:7px solid white; background-color:rgba(25, 0, 0, 0.5);">
        //                                 <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_position->country_code) . '" alt="#" width="40px">
        //                                 <h1 class="text-uppercase name-network">' . $row_position->username . '</h1>
        //                                 <p>' . $row_position->fm . '</p>
        //                                 <div class="d-flex justify-content-center align-content-center align-items-center position-relative">
        //                                     <div class="text-right">
        //                                         <p>(' . $idLeft . ' ID) left</p>
        //                                         <p style="color:white">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
        //                                         <p>Increase</p>
        //                                         <p style="color:white">+ ' . $pointTodayL . '</p>
        //                                     </div>
        //                                     <div class="line"></div>
        //                                     <div class="text-left">
        //                                         <p>right (' . $idRight . ' ID)</p>
        //                                         <p style="color:white">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
        //                                         <p>Increase</p>
        //                                         <p style="color:white">+ ' . $pointTodayR . '</p>
        //                                     </div>
        //                                 </div>
        //                                 <p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
        //                             </div>
        //                         </a>';

        //         $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);

        //         $output .=    '</li>';
        //     }

        //     $output .=  '</ul>';
        // }
        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }
    
    public function showDownline()
    {
        $id             = $this->input->post('user');
        $query_position = $this->M_user->get_network_byposition($id);

        $level          = $this->input->post('level');

        if(empty($level))
        {
            $endLoop = 0;
        }
        else
        {
            $endLoop        = $level -1;
        }

        $output         = '';

        if (count($query_position) != '') 
        {
            $output .= '<ul>';
    
            foreach ($query_position as $row_position) 
            {
                $countLeft      = $this->countPositionL($row_position->user_id);
                $countRight     = $this->countPositionR($row_position->user_id);
                $balancePoint   = $this->balance_point($row_position->user_id);
                $pointTodayL    = $this->countPointTodayL($row_position->user_id);
                $pointTodayR    = $this->countPointTodayR($row_position->user_id);
                $idLeft         = $this->countIDL($row_position->user_id);
                $idRight        = $this->countIDR($row_position->user_id);
                $query_box      = $this->M_user->sumPackage($row_position->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);
    
                if ($balancePoint) {
                    $balance_a = $balancePoint['balance_a'] + $pointTodayL;
                    $balance_b = $balancePoint['balance_b'] + $pointTodayR;
                } else {
                    if($pointTodayL != 0)
                    {
                        $balance_a = $pointTodayL;
                    }
                    else
                    {
                        $balance_a = $pointTodayL+$countLeft;
                    }

                    if($pointTodayR != 0)
                    {
                        $balance_b = $pointTodayR;
                    }
                    else
                    {
                        $balance_b = $pointTodayR+$countRight;
                    }
                }
    
                $output .=    '<li>';
                $output .=      '<div class="item" style="border: 7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                                    <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_position->country_code) . '" alt="#" width="40px">
                                    <h1 class="text-uppercase name-network" id="'.$row_position->username.'">' . $row_position->username . '</h1>
                                    <p>' . $row_position->fm . '</p>
                                    <div class="d-flex justify-content-center align-content-center align-items-center position-relative">
                                        <div class="text-right">
                                            <p>(' . $idLeft . ' ID) left</p>
                                            <p style="color:white">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                            <p>Increase</p>
                                            <p style="color:white">+ ' . $pointTodayL . '</p>
                                        </div>
                                        <div class="line"></div>
                                        <div class="text-left">
                                            <p>right (' . $idRight . ' ID)</p>
                                            <p style="color:white">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                            <p>Increase</p>
                                            <p style="color:white">+ ' . $pointTodayR . '</p>
                                        </div>
                                    </div>';

                $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .=     '<p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
                                    <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                        <i class="fas fa-caret-up"></i>
                                    </button>
                                </div>';

                    $output .= '<div id="result'.$row_position->user_id.'" class="displayNetwork">';
                    
                    $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);

                    $output .= '</div>';

                }
                else
                {
                    $output .=     '<p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
                                    <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';

                    $output .= '<div id="result'.$row_position->user_id.'" class="hideNetwork">';
                    
                    $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);
                    
                    $output .= '</div>';
                }
                    
    
                $output .=    '</li>';
                
            }

            $output .= '</ul>';
        }
        echo $output;
    }

    private function _loopingNetwork($firstLoop, $endLoop, $user_id)
    {
        if($firstLoop > $endLoop)
        {
            return false;
        }

        $query_position = $this->M_user->get_network_byposition($user_id);

        $output = '';

        if (count($query_position) != '') {
            $output .= '<ul>';

            foreach ($query_position as $row_position) {
                $countLeft      = $this->countPositionL($row_position->user_id);
                $countRight     = $this->countPositionR($row_position->user_id);
                $balancePoint   = $this->balance_point($row_position->user_id);
                // $increaseLeft   = $this->countPositionL($row_position->user_id) - $this->increasePoint($row_position->user_id, 'L');
                // $increaseRight  = $this->countPositionR($row_position->user_id) - $this->increasePoint($row_position->user_id, 'R');
                $pointTodayL    = $this->countPointTodayL($row_position->user_id);
                $pointTodayR    = $this->countPointTodayR($row_position->user_id);
                $idLeft         = $this->countIDL($row_position->user_id);
                $idRight        = $this->countIDR($row_position->user_id);
                $query_box      = $this->M_user->sumPackage($row_position->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);

                if ($balancePoint) {
                    // $balance_a = $balancePoint['amount_left'] + $increaseLeft;
                    // $balance_b = $balancePoint['amount_right'] + $increaseRight;
                    $balance_a = $balancePoint['balance_a'] + $pointTodayL;
                    $balance_b = $balancePoint['balance_b'] + $pointTodayR;
                } else {
                    $balance_a = $countLeft;
                    $balance_b = $countRight;
                }

                $output .=    '<li>';

                $output .=      '<div class="item" style="border:7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                                        <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_position->country_code) . '" alt="#" width="40px">
                                        <h1 class="text-uppercase name-network">' . $row_position->username . '</h1>
                                        <p>' . $row_position->fm . '</p>
                                        <div class="d-flex justify-content-center align-content-center align-items-center position-relative">
                                            <div class="text-right">
                                                <p>(' . $idLeft . ' ID) left</p>
                                                <p style="color:white">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                                <p>Increase</p>
                                                <p style="color:white">+ ' . $pointTodayL . '</p>
                                            </div>
                                            <div class="line"></div>
                                            <div class="text-left">
                                                <p>right (' . $idRight . ' ID)</p>
                                                <p style="color:white">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                                <p>Increase</p>
                                                <p style="color:white">+ ' . $pointTodayR . '</p>
                                            </div>
                                        </div>';

                $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .=      '<p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
                                    <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';
                }
                else
                {
                    $output .=      '<p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0);">' . $package_name . ' BOX</p>
                                    <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';
                }

                if($firstLoop == $endLoop)
                {
                    $output .= '<div id="result'.$row_position->user_id.'" class="hideNetwork">';
                }
                else
                {
                    $output .= '<div id="result'.$row_position->user_id.'" class="displayNetwork">';
                }
                
                //looping
                $output .= $this->_loopingNetwork($firstLoop + 1, $endLoop, $row_position->user_id);
                
                $output .= '</div>';

                $output .=      '</li>';
            }

            $output .= '</ul>';
        }

        return $output;
    }

    /**Count total id network left */
    public function countIDL($userid)
    {
        $query          = $this->M_user->check_line($userid, 'A');
        $user_position  = $query['user_id'] ?? null;
        $this->arr = array();

        if (!empty($user_position)) {
            $countId = count($this->get_countMember($user_position)) + 1;
        } else {
            $countId = count($this->get_countMember($user_position));
        }

        return $countId;
    }

    /**Count total id network right */
    public function countIDR($userid)
    {
        $query          = $this->M_user->check_line($userid, 'B');
        $user_position  = $query['user_id'] ?? null;
        $this->arr = array();

        if (!empty($user_position)) {
            $countId = count($this->get_countMember($user_position)) + 1;
        } else {
            $countId = count($this->get_countMember($user_position));
        }

        return $countId;
    }


    public function balance_point($userid)
    {
        //$query = $this->M_user->balance_now($userid)->row_array();
        $query = $this->M_user->balance_now_nol($userid)->row_array();
        return $query;
    }

    public function increasePoint($userid, $position)
    {
        // $query_poin = $this->M_user->secondlast_balance($userid);
        // $getAmount = $query_poin['set_amount'];

        // $query_cutPoint = $this->M_user->sum_leftover($userid);
        // $cutPointLeft = $query_cutPoint['amount_left'];
        // $cutPointRight = $query_cutPoint['amount_right'];

        // $increasePointLeft = $cutPointLeft+$getAmount;
        // $increasePointRight = $cutPointRight+$getAmount;

        $query_set =  $this->M_user->sum_balance($userid);

        if ($query_set) {
            $total_set = $query_set['set_amount'];
        } else {
            $total_set = 0;
        }

        $query_balance_now = $this->M_user->balance_now($userid)->row_array();

        if ($query_balance_now) {
            $balance_now_left = $query_balance_now['amount_left'];
            $balance_now_right = $query_balance_now['amount_right'];
        } else {
            $balance_now_left = 0;
            $balance_now_right = 0;
        }

        $total_before_left = $total_set + $balance_now_left;
        $total_before_right = $total_set + $balance_now_right;

        if ($position == 'L') {
            return $total_before_left;
        } else {
            return $total_before_right;
        }
    }

    public function showLine($id)
    {
        $query_line = $this->M_user->get_network_byposition($id);

        return json_decode(json_encode($query_line), true);
    }

    public function sponsornet()
    {
        $this->_unset_payment();

        $data['title'] = 'Sponsor';

        if ($this->uri->segment(3) != '') {
            $id = $this->uri->segment(3);

            $query_user = $this->M_user->get_user_byid($id);
        } else {
            $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        }
        
        $idLeft         = $this->countIDL($query_user['id']);
        $idRight        = $this->countIDR($query_user['id']);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);

        $data['user']           = $query_user;
        $data['cart']           = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['amount_notif']   = $query_row_notif;
        $data['list_notif']     = $query_new_notif;
        $data['sponsor']        = $this->_showSponsor($query_user['id'], $query_user['country_code'], $query_user['username']);

        $sidebar['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //$sidebar['cart'] = $this->M_user->show_data_home($sidebar['user']['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/sponsornet', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    private function _showSponsor($id, $countryCode, $username)
    {
        $package        = $this->M_user->get_box_fm($id)->row_array();
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);
        $query_box      = $this->M_user->sumPackage($id);
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);
        
        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden; transform:scale(' . $scale . ')">';
        $output .=    '<div class="item" style="border: 7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="" width="40px">
                            <h1 class="text-uppercase name-network">' . $username . '</h1>
                            <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                <img src="' . base_url('assets/img/white-box.png') . '" alt="#" height="90px">
                                <p style="position: absolute; bottom:10px">ME</p>
                            </div>
                            <p class="box-network font-weight-bold" style="background-color: white; color:rgba(25, 0, 0, 0.5);">' . $package_name . ' BOX</p>
                            <button id="'.$id.'" onClick="reply_click_user(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';

        // if (count($query_sponsor) != '') {
        //     $output .= '<ul>';
        //     foreach ($query_sponsor as $row_sponsor) {
        //         $team = $this->_sponsorTeam($id, $row_sponsor->user_id);
        //         $query_box      = $this->M_user->sumPackage($row_sponsor->user_id);
        //         $package_name   = $query_box['point'] ?? null;
        //         $package_color  = $this->_color_network($package_name);

        //         $output .=    '<li>';
        //         $output .=      '<a href="' . base_url('user/sponsornet/') . $row_sponsor->user_id . '">
        //                             <div class="item" style="border:7px solid white; background-color:rgba(25, 0, 0, 0.5);">
        //                                 <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_sponsor->country_code) . '" alt="" width="40px">
        //                                 <h1 class="text-uppercase name-network">' . $row_sponsor->username . '</h1>
        //                                 <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
        //                                     <img src="' . base_url('assets/img/white-box.png') . '" alt="#" height="90px">
        //                                     <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
        //                                     <p style="position: absolute; bottom:10px">' . $team . '</p>
        //                                 </div>
        //                                 <p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0, 0.5);">' . $package_name . ' BOX</p>
        //                             </div>
        //                         </a>';

        //         $output .= $this->_loopingSponsor($row_sponsor->user_id);

        //         $output .=    '</li>';
        //     }
        //     $output .=  '</ul>';
        // }
        
            $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';
        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }
    
    public function showSponsorBottom()
    {
        $id             = $this->input->post('user');
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);

        $output = '';

        if (count($query_sponsor) != '') 
        {
            $output .= '<ul>';

            foreach ($query_sponsor as $row_sponsor) 
            {
                $team           = $this->_sponsorTeam($id, $row_sponsor->user_id);
                $query_box      = $this->M_user->sumPackage($row_sponsor->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);

                $output .=    '<li>';

                $output .=      '<div class="item" style="border: 7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                                    <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_sponsor->country_code) . '" alt="" width="40px">
                                    <h1 class="text-uppercase name-network" id="'.$row_sponsor->username.'">' . $row_sponsor->username . '</h1>
                                    <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                        <img src="' . base_url('assets/img/white-box.png') . '" alt="#" height="90px">
                                        <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                        <p style="position: absolute; bottom:10px">' . $team . '</p>
                                    </div>
                                    <p class="box-network font-weight-bold" style="background-color: white; color:rgba(25, 0, 0, 0.5);">' . $package_name . ' BOX</p>
                                    <button id="'.$row_sponsor->user_id.'" onClick="reply_click_user(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';

                $output .= '<div id="result'.$row_sponsor->user_id.'" class="hideNetwork"></div>';    
                $output .=    '</li>';
            }

            $output .= '</ul>';
        }

        echo $output;
    }

    private function _loopingSponsor($id)
    {
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);

        $output = '';

        if (count($query_sponsor) != '') {
            $output .= '<ul>';

            foreach ($query_sponsor as $row_sponsor) {
                $team           = $this->_sponsorTeam($id, $row_sponsor->user_id);
                $query_box      = $this->M_user->sumPackage($row_sponsor->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);

                $output .=    '<li>';

                $output .=      '<a href="' . base_url('user/sponsornet/') . $row_sponsor->user_id . '">
                                    <div class="item" style="border:7px solid white; background-color:rgba(25, 0, 0, 0.5);">
                                        <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_sponsor->country_code) . '" alt="" width="40px">
                                        <h1 class="text-uppercase name-network">' . $row_sponsor->username . '</h1>
                                        <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                            <img src="' . base_url('assets/img/white-box.png') . '" alt="" height="90px">
                                            <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                            <p style="position: absolute; bottom:10px">' . $team . '</p>
                                        </div>
                                        <p class="box-network font-weight-bold" style="background-color:white; color:rgba(25, 0, 0, 0.5);">' . $package_name . ' BOX</p>
                                    </div>
                                </a>';
                //looping
                $output .= $this->_loopingSponsor($row_sponsor->user_id);

                $output .=      '</li>';
            }

            $output .= '</ul>';
        }

        return $output;
    }

    private function _sponsorTeam($sponsor, $member)
    {
        $query = $this->M_user->get_userid_bysponsor($sponsor)->result_array();
        $value = $member;

        $team_number = $this->_searchArray($value, $query);

        if ($team_number >= 0 && $team_number <= 2) {
            $team_name = 'TEAM A';
        } elseif ($team_number >= 3 && $team_number <= 5) {
            $team_name = 'TEAM B';
        } elseif ($team_number >= 6) {
            $team_name = 'TEAM C';
        }

        return $team_name;
    }

    private function _searchArray($value, $array)
    {
        return array_search($value, array_column($array, 'user_id'));
    }

    public function showSponsorMemberA($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '3', '0');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMemberB($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '3', '3');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMemberC($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '6', '6');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMember($id)
    {
        $query_line = $this->M_user->get_sponsor_member1($id);

        return json_decode(json_encode($query_line), true);
    }

    public function get_countMember($id)
    {
        $query = $this->M_user->get_totaluser_byposition($id);

        foreach ($query->result() as $row) {

            array_push($this->arr, $row->user_id);

            $this->get_countMember($row->user_id);
        }

        return $this->arr;
    }

    public function get_countMemberSponsor($id)
    {
        $query = $this->M_user->get_totaluser_bysponsor($id);

        foreach ($query->result() as $row) {
            array_push($this->arr2, $row->user_id);

            $this->get_countMemberSponsor($row->user_id);
        }

        return $this->arr2;
    }

    public function countPointTodayL($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->get_countPointTodayL($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayL = array();

        return $sumTotal;
    }

    public function get_countPointTodayL($id, $date)
    {
        // $query = $this->M_user->get_totalpoin_byposition($id);
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayL, $row->point);
            // }

            array_push($this->arrTodayL, $row->point);

            $this->get_countPointTodayL($row->user_id, $date);
        }

        return $this->arrTodayL;
    }

    public function countPointTodayR($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'B');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->get_countPointTodayR($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayR = array();

        return $sumTotal;
    }

    public function get_countPointTodayR($id, $date)
    {
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayR, $row->point);
            // }

            array_push($this->arrTodayR, $row->point);

            $this->get_countPointTodayR($row->user_id, $date);
        }

        return $this->arrTodayR;
    }

    /**Count total omset network left */
    public function countPositionL($userid)
    {
        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package       = $query_package['point'] ?? null;

        $countMember = $this->get_countPointL($user_position);

        $sumTotal = array_sum($countMember) + $package;
        $this->arrPointL = array();

        return $sumTotal;
    }

    public function get_countPointL($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach ($query->result() as $row) {
            array_push($this->arrPointL, $row->point);

            $this->get_countPointL($row->user_id);
        }

        return $this->arrPointL;
    }

    /**Count total omset network position R */
    public function countPositionR($userid)
    {
        $query = $this->M_user->check_line($userid, 'B');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package_poin  = $query_package['point'] ?? null;

        $countMember = $this->get_countPointR($user_position);

        $sumTotal = array_sum($countMember) + $package_poin;
        $this->arrPointR = array();

        return $sumTotal;
    }

    public function get_countPointR($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach ($query->result() as $row) {
            array_push($this->arrPointR, $row->point);

            $this->get_countPointR($row->user_id);
        }

        return $this->arrPointR;
    }

    //url bonus perhari matching
    public function pairingmatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_pairing_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_pairing_byid($query_user['id']);

        $data['title']              = 'Pairing';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_excess']       = $this->M_user->get_excess_pairing($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['total_zenx']         = $query_total['zenx'];
        $data['total_zenx_excess']  = $query_total_excess['zenx'];

        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/pairing_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    //my wallet link
    public function mywallet()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'My Wallet';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/my_wallet', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_transfer_list        = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'filecoin', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']                  = 'Fill General Balance';
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil']    = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['fill'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'filecoin')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '1');
        $data['purchase']               = $this->M_user->get_purchase_fill_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillmining()
    {
        $this->_unset_payment();

        $query_user          = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif     = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif     = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_mining        = $this->M_user->show_all_byid($query_user['id'], 'mining_user', 'user_id');
        $query_total         = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['title']              = 'Fill Mining Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['list_mining']        = $query_mining;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/mining', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillbonus()
    {
        $this->_unset_payment();

        $query_user                = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif           = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif           = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total               = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_transfer_bonus_list = $this->M_user->get_transfer_bonus_list($query_user['id'], 'filecoin', 'DESC')->result();

        $data['title']              = 'Fill Bonus Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_fil']          = $query_total['sponsorfil'] + $query_total['sponmatchingfil'] + $query_total['minmatching'] + $query_total['minpairing'];
        $data['balance']            = $data['total_fil'] - $query_transfer_bonus_fill['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_minmatching_list'] = $this->M_user->get_bonus_miningmatching($query_user['id']);
        $data['bonus_minpairing_list'] = $this->M_user->get_bonus_miningpairing($query_user['id'])->get()->result();
        $data['bonus_basecamp_list'] = $this->M_user->get_bonus_basecamp($query_user['id']);
        $data['bonus_basecamp2_list'] = $this->M_user->get_bonus_basecamp2($query_user['id']);
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_mtm         = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_transfer_list        = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'mtm', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']                  = 'MTM General Balance';
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_mtm']    = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['mtm'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'mtm')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '2');
        $data['purchase']               = $this->M_user->get_purchase_mtm_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmairdrop()
    {
        $this->_unset_payment();

        $query_user          = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif     = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif     = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_airdrops      = $this->M_user->show_all_byid($query_user['id'], 'airdrop_mtm', 'user_id');
        $query_sum_air       = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['title']              = 'MTM Air Drops Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['airdrops']           = $query_airdrops;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_sum_air['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/airdrops', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmbonus()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'mtm', 'DESC')->result();

        $data['title']              = 'MTM Bonus Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_mtm']          = $query_total['sponsormtm'] + $query_total['sponmatchingmtm'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampmtm'];
        $data['balance']            = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_pairingmatch_list'] = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_binary_list']  = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['bonus_global_list']  = $this->M_user->get_bonus_global($query_user['id']);
        $data['bonus_basecamp_list'] = $this->M_user->get_bonus_basecamp2($query_user['id']);
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_bonus_zenx  = $this->M_user->get_transfer_bonus($query_user['id'], 'zenx');
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'zenx', 'DESC')->result();
        $query_transfer_zenx        = $this->M_user->get_total_byuser('airdrop_zenx_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list        = $this->M_user->get_transfer_list('airdrop_zenx_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'zenx');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $query_total = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $total_sponsorzenx = $query_total['sponsorzenx'] ?? null;
        $total_sponmatchingzenx = $query_total['sponmatchingzenx'] ?? null;
        $total_pairingmatch_zenx = $query_total['pairingmatch'] ?? null;
        $total_binarymatch_zenx = $query_total['binarymatch'] ?? null;
        $total_bonusglobal_zenx = $query_total['bonusglobal'] ?? null;
        $total_basecampzenx = $query_total['basecampzenx'] ?? null;

        $query_total_zenx          = $this->M_user->get_total_byuser('airdrop_zenx', 'amount', 'user_id', $query_user['id']);

        $data['title']              = 'ZENX General Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['deposit']            = $this->M_user->get_deposit_general($query_user['id'], '3');
        $data['general']            = $query_transfer_bonus_zenx['amount'] + $query_transfer_zenx['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['zenx'] - $query_total_withdrawal['amount'];
        $data['purchase']           = $this->M_user->get_purchase_zenx_byid($query_user['id']);
        $data['withdrawal']         = $this->M_user->get_withdrawal_by($query_user['id'], 'zenx')->result();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();
        $data['detail']             = $this->M_user->get_detail_user($query_user['id'])->row_array();
        $data['excess_bonus']       = $this->M_user->get_excess_bonus($query_user['id'])->row_array();
        $data['transfer_list_mining'] = $query_transfer_list;
        $data['transfer_list_bonus'] = $query_transfer_bonus_list;
        $data['total_zenx']         = $total_sponsorzenx + $total_sponmatchingzenx + $total_pairingmatch_zenx + $total_binarymatch_zenx + $total_bonusglobal_zenx + $total_basecampzenx;
        $data['mining_zenx_total']  = isset($query_total_zenx['amount']) ? $query_total_zenx['amount'] : 0;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxairdrop()
    {
        $this->_unset_payment();

        $query_user          = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif     = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif     = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_airdrops      = $this->M_user->show_all_byid($query_user['id'], 'airdrop_zenx', 'user_id');
        $query_sum_air       = $this->M_user->get_total_byuser('airdrop_zenx', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('airdrop_zenx_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('airdrop_zenx_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['title']              = 'ZENX Air Drops Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['airdrops']           = $query_airdrops;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_sum_air['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/airdrops', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxbonus()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_zenx   = $this->M_user->get_transfer_bonus($query_user['id'], 'zenx');
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'zenx', 'DESC')->result();

        $data['title']              = 'ZENX Bonus Balance';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_zenx']         = $query_total['sponsorzenx'] + $query_total['sponmatchingzenx'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampzenx'];
        $data['balance']            = $data['total_zenx'] - $query_transfer_bonus_zenx['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_pairingmatch_list'] = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_binary_list']  = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['bonus_global_list']  = $this->M_user->get_bonus_global($query_user['id']);
        $data['bonus_basecamp_list'] = $this->M_user->get_bonus_basecamp($query_user['id']);
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function myteam()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_team_a       = $this->M_user->get_team($query_user['id'], '3', '0');
        $query_team_b       = $this->M_user->get_team($query_user['id'], '3', '3');
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);
        $query_team_c       = $this->M_user->get_team($query_user['id'], $query_row_team, '6');

        $data['title']              = 'My Team';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['team_a']             = $query_team_a;
        $data['team_b']             = $query_team_b;
        $data['team_c']             = $query_team_c;
        $data['userClass']          = $this;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/myteam', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function miningMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_minmatch_byid($query_user['id']);

        $data['title']              = 'Recommended Mining';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_miningmatching($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['amount'];


        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/mining_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function binaryMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_pairingmatch_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_pairingmatch_byid($query_user['id']);

        $data['title']              = 'Pairing Matching';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['excess']             = $this->M_user->get_excess_binarymatch($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['zenx'];
        $data['total_excess']       = $query_total_excess['zenx'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/binary_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function bonusGlobal()
    {
        $this->_unset_payment();

        $dateNow    = date('Y-m-d');
        $monthNow   = date('m');

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_global_byid($query_user['id']);


        $data['title']              = 'Bonus Global';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_global($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['zenx'];


        $fm = $data['cart']['fm'] ?? null;

        $query_fm_today         = $this->M_user->get_today_fm($fm, $dateNow);
        $query_all_fm           = $this->M_user->get_all_fm($fm);
        $query_today_omset      = $this->M_user->get_today_purchase($dateNow);
        $query_current_omset    = $this->M_user->get_currentmonth_purchase($monthNow);

        $data['today_fm']        = $query_fm_today;
        $data['all_fm']          = $query_all_fm;
        $data['today_omset']     = $query_today_omset['fil'];
        $data['current_omset']   = $query_current_omset['fil'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/global', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function achievement()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_sponsor      = $this->M_user->sum_sponsorbox($query_user['id']);
        $omset              = $this->_omset_bysponsor($query_user['id']);
        $count_fm1          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM1');
        $count_fm2          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM2');
        $count_fm3          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM3');
        $count_fm4          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM4');
        $count_fm5          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM5');
        $count_fm6          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM6');
        $count_fm7          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM7');
        $count_fm8          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM8');
        $count_fm9          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM9');
        $count_fm10         = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM10');
        $team_a             = $this->M_user->get_team($query_user['id'], 3, 0);
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);
        $team_c             = $this->M_user->get_team($query_user['id'], $query_row_team, '6');

        $total_sponsor = 0;
        foreach ($query_sponsor as $row_sponsor) {
            $total_sponsor = $total_sponsor + $row_sponsor->point;
        }

        $sponsor            = $total_sponsor;

        $count_a1  = 0;
        $count_a2  = 0;
        $count_a3  = 0;
        $count_a4  = 0;
        $count_a5  = 0;
        $count_a6  = 0;
        $count_a7  = 0;
        $count_a8  = 0;
        $count_a9  = 0;
        $count_a10  = 0;

        foreach ($team_a as $row_team_a) {
            if ($row_team_a->fm == 'FM1') {
                $count_a1 = $count_a1 + 1;
            } elseif ($row_team_a->fm == 'FM2') {
                $count_a2 = $count_a2 + 1;
            } elseif ($row_team_a->fm == 'FM3') {
                $count_a3 = $count_a3 + 1;
            } elseif ($row_team_a->fm == 'FM4') {
                $count_a4 = $count_a4 + 1;
            } elseif ($row_team_a->fm == 'FM5') {
                $count_a5 = $count_a5 + 1;
            } elseif ($row_team_a->fm == 'FM6') {
                $count_a6 = $count_a6 + 1;
            } elseif ($row_team_a->fm == 'FM7') {
                $count_a7 = $count_a7 + 1;
            } elseif ($row_team_a->fm == 'FM8') {
                $count_a8 = $count_a8 + 1;
            } elseif ($row_team_a->fm == 'FM9') {
                $count_a9 = $count_a9 + 1;
            } elseif ($row_team_a->fm == 'FM10') {
                $count_a10 = $count_a10 + 1;
            }
        }

        $count_c7  = 0;
        $count_c8   = 0;
        $count_c9   = 0;
        $count_c10   = 0;

        foreach ($team_c as $row_team_c) {
            if ($row_team_c->fm == 'FM7') {
                $count_c7 = $count_c7 + 1;
            } elseif ($row_team_c->fm == 'FM8') {
                $count_c8 = $count_c8 + 1;
            } elseif ($row_team_c->fm == 'FM9') {
                $count_c9 = $count_c9 + 1;
            } elseif ($row_team_c->fm == 'FM10') {
                $count_c10 = $count_c10 + 1;
            }
        }

        $data['title']              = 'Achievements';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['sponsor']            = $sponsor;
        $data['omset']              = $omset;
        $data['fm1']                = $count_fm1;
        $data['fm2']                = $count_fm2;
        $data['fm3']                = $count_fm3;
        $data['fm4']                = $count_fm4;
        $data['fm5']                = $count_fm5;
        $data['fm6']                = $count_fm6;
        $data['fm7']                = $count_fm7;
        $data['fm8']                = $count_fm8;
        $data['fm9']                = $count_fm9;
        $data['fm10']               = $count_fm10;
        $data['team_a1']            = $count_a1;
        $data['team_a2']            = $count_a2;
        $data['team_a3']            = $count_a3;
        $data['team_a4']            = $count_a4;
        $data['team_a5']            = $count_a5;
        $data['team_a6']            = $count_a6;
        $data['team_a7']            = $count_a7;
        $data['team_a8']            = $count_a8;
        $data['team_a9']            = $count_a9;
        $data['team_a10']           = $count_a10;
        $data['team_c7']            = $count_c7;
        $data['team_c8']            = $count_c8;
        $data['team_c9']            = $count_c9;
        $data['team_c10']           = $count_c10;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/achievement', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    private function _omset_bysponsor($user_id)
    {
        $countMember = $this->_get_countPointSponsor($user_id);

        $sumTotal = array_sum($countMember);
        $this->arrPointSpon = array();

        return $sumTotal;
    }

    private function _get_countPointSponsor($user_id)
    {
        $query = $this->M_user->sum_sponsorbox($user_id);

        foreach ($query as $row) {
            array_push($this->arrPointSpon, $row->point);

            $this->_get_countPointSponsor($row->user_id);
        }

        return $this->arrPointSpon;
    }

    public function information_detail()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_detail       = $this->M_user->get_information_detail($query_user['id']);

        $data['title']              = 'Information Detail';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['information_detail'] = $query_detail;
        $datacart_updatedate        = $data['cart']['update_date'] ?? null;

        $mining_payment = date('Y-m-d', $datacart_updatedate);

        $date_fil = new DateTime($mining_payment);
        $date_fil->modify('45 days');
        $data['fil_startpayment'] = $date_fil->format('Y/m/d');
        $date_fil->modify('1100 days');
        $data['fil_endpayment'] = $date_fil->format('Y/m/d');

        $date_mtm = new DateTime($mining_payment);
        $date_mtm->modify('1 week');
        $data['mtm_startpayment'] = $date_mtm->format('Y/m/d');
        $date_mtm->modify('540 days');
        $data['mtm_endpayment'] = $date_mtm->format('Y/m/d');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/information_detail', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function upload()
    {
        $data = array();

        if ($this->input->post('submit')) { // Jika user menekan tombol Submit (Simpan) pada form
            // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
            $upload = $this->M_user->upload_photo();

            if ($upload['result'] == "success") { // Jika proses upload sukses
                // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                $this->M_user->save_photo($upload);

                redirect('user/information_detail'); // Redirect kembali ke halaman awal / halaman view data
            } else { // Jika proses upload gagal
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Error</div>');
            }
        }

        $this->load->view('user/information_detail', $data);
    }

    function switch($language)
    {
        $this->session->set_userdata('language', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function marketing_plan()
    {
        // $language = $this->session->userdata('language');
        // $this->load->language('marketingPlan', $language);

        $language = $this->input->post('language');

        $this->load->language('marketingPlan', $language);
        $this->session->set_userdata('language', $language);

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Marketing Plan';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);

        // language data
        $data['table_th_1'] = $this->lang->line('table_th_1');
        $data['table_th_2'] = $this->lang->line('table_th_2');
        $data['td_fm'] = $this->lang->line('td_fm');
        $data['td_fm1'] = $this->lang->line('td_fm1');
        $data['td_fm2'] = $this->lang->line('td_fm2');
        $data['td_fm3'] = $this->lang->line('td_fm3');
        $data['td_fm4'] = $this->lang->line('td_fm4');
        $data['td_fm5'] = $this->lang->line('td_fm5');
        $data['td_fm6'] = $this->lang->line('td_fm6');
        $data['td_fm7'] = $this->lang->line('td_fm7');
        $data['td_fm8'] = $this->lang->line('td_fm8');
        $data['td_fm9'] = $this->lang->line('td_fm9');
        $data['td_fm10'] = $this->lang->line('td_fm10');

        $data['bonus_sponsor_title'] = $this->lang->line('bonus_sponsor_title');
        $data['bonus_sponsor_1'] = $this->lang->line('bonus_sponsor_1');
        $data['bonus_sponsor_2'] = $this->lang->line('bonus_sponsor_2');
        $data['bonus_sponsor_3'] = $this->lang->line('bonus_sponsor_3');
        $data['bonus_sponsor_4'] = $this->lang->line('bonus_sponsor_4');
        $data['bonus_sponsor_5'] = $this->lang->line('bonus_sponsor_5');
        $data['bonus_sponsor_6'] = $this->lang->line('bonus_sponsor_6');
        $data['img_bonus_sponsor'] = $this->lang->line('img_bonus_sponsor');

        $data['sponsor_matching_title'] = $this->lang->line('sponsor_matching_title');
        $data['sponsor_matching_1'] = $this->lang->line('sponsor_matching_1');
        $data['sponsor_matching_2'] = $this->lang->line('sponsor_matching_2');
        $data['sponsor_matching_3'] = $this->lang->line('sponsor_matching_3');
        $data['sponsor_matching_4'] = $this->lang->line('sponsor_matching_4');
        $data['sponsor_matching_5'] = $this->lang->line('sponsor_matching_5');
        $data['sponsor_matching_6'] = $this->lang->line('sponsor_matching_6');
        $data['img_sponsor_matching'] = $this->lang->line('img_sponsor_matching');

        $data['recommended_mining_title'] = $this->lang->line('recommended_mining_title');
        $data['recommended_mining_1'] = $this->lang->line('recommended_mining_1');
        $data['recommended_mining_2'] = $this->lang->line('recommended_mining_2');
        $data['recommended_mining_3'] = $this->lang->line('recommended_mining_3');
        $data['recommended_mining_4'] = $this->lang->line('recommended_mining_4');
        $data['recommended_mining_5'] = $this->lang->line('recommended_mining_5');
        $data['recommended_mining_6'] = $this->lang->line('recommended_mining_6');
        $data['img_recommended_mining'] = $this->lang->line('img_recommended_mining');

        $data['recommended_mining_4'] = $this->lang->line('recommended_mining_4');
        $data['recommended_mining_5'] = $this->lang->line('recommended_mining_5');
        $data['recommended_mining_6'] = $this->lang->line('recommended_mining_6');
        $data['img_recommended_mining'] = $this->lang->line('img_recommended_mining');

        $data['recommended_mining_3'] = $this->lang->line('recommended_mining_3');
        $data['recommended_mining_4'] = $this->lang->line('recommended_mining_4');
        $data['recommended_mining_5'] = $this->lang->line('recommended_mining_5');
        $data['recommended_mining_6'] = $this->lang->line('recommended_mining_6');
        $data['img_recommended_mining'] = $this->lang->line('img_recommended_mining');

        $data['mining_generasi_title'] = $this->lang->line('mining_generasi_title');
        $data['mining_generasi_1'] = $this->lang->line('mining_generasi_1');
        $data['mining_generasi_2'] = $this->lang->line('mining_generasi_2');
        $data['mining_generasi_3'] = $this->lang->line('mining_generasi_3');
        $data['img_mining_generasi'] = $this->lang->line('img_mining_generasi');

        $data['pairing_mining_title'] = $this->lang->line('pairing_mining_title');
        $data['pairing_mining_1'] = $this->lang->line('pairing_mining_1');
        $data['pairing_mining_2'] = $this->lang->line('pairing_mining_2');
        $data['pairing_mining_3'] = $this->lang->line('pairing_mining_3');
        $data['pairing_mining_4'] = $this->lang->line('pairing_mining_4');
        $data['pairing_mining_5'] = $this->lang->line('pairing_mining_5');
        $data['pairing_mining_6'] = $this->lang->line('pairing_mining_6');
        $data['img_pairing_mining'] = $this->lang->line('img_pairing_mining');

        $data['pairing_matching_title'] = $this->lang->line('pairing_matching_title');
        $data['pairing_matching_1'] = $this->lang->line('pairing_matching_1');
        $data['pairing_matching_2'] = $this->lang->line('pairing_matching_2');
        $data['pairing_matching_3'] = $this->lang->line('pairing_matching_3');
        $data['img_pairing_matching'] = $this->lang->line('img_pairing_matching');

        $data['bonus_global_title'] = $this->lang->line('bonus_global_title');
        $data['bonus_global_1'] = $this->lang->line('bonus_global_1');
        $data['bonus_global_2'] = $this->lang->line('bonus_global_2');
        $data['bonus_global_3'] = $this->lang->line('bonus_global_3');
        $data['img_bonus_global'] = $this->lang->line('img_bonus_global');

        $data['bonus_basecamp_title'] = $this->lang->line('bonus_basecamp_title');
        $data['bonus_basecamp_1'] = $this->lang->line('bonus_basecamp_1');
        $data['bonus_basecamp_2'] = $this->lang->line('bonus_basecamp_2');
        $data['bonus_basecamp_3'] = $this->lang->line('bonus_basecamp_3');
        $data['img_bonus_basecamp'] = $this->lang->line('img_bonus_basecamp');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/marketing_plan', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function market_trade()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Market Trade';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/market_trade', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    //show modal notification limit mining
    public function modalLimitMining()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $id_notif   = $this->input->post('item_id');

        //show single notification
        $query_notif = $this->M_user->show_notif_byuser($id_notif, $query_user['id']);
        $data['message']    = $query_notif['message'];
        $data['link']       = $query_notif['link'] . '/' . $id_notif;

        $this->load->view('user/modal/notif_mining', $data);
    }

    public function updateDaysMining()
    {
        $cartid     = $this->uri->segment(3);
        $notifid    = $this->uri->segment(4);
        $stat       = $this->uri->segment(5);

        $data = [
            'pause_min' => $stat
        ];

        $data_notif = [
            'is_show' => 1
        ];

        $update_cart = $this->M_user->update_data_byid('cart', $data, 'id', $cartid);

        if ($update_cart) {
            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $notifid);
            if ($update_notif) {
                if ($stat == 2) {
                    $message = 'Your mining time limit has been extended.';
                } else {
                    $message = 'Your mining timeout has been stopped.';
                }

                $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">' . $message . '</div>');
                redirect('user/index');
            }
        }
    }

    //show lish notification
    public function listNotification()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));

        //show list notification
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $data2['list_notif'] = $query_new_notif;
        $data2['amount_notif'] = $query_row_notif;

        $this->load->view('user/notification', $data2);
    }

    public function setting()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Setting';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/setting/index', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    public function changeEmail()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {

                $this->form_validation->set_rules('email', 'Current Email', 'trim|required');
                $this->form_validation->set_rules('email2', 'New Email', 'trim|required');
                $this->form_validation->set_rules('check_code1', 'Current Email Code', 'trim|required');
                $this->form_validation->set_rules('check_code2', 'New Email Code', 'trim|required');

                $code1 = date('mHd');

                if ($this->form_validation->run() == false) {
                    $data['title'] = 'Change Email';
                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/setting/change_email', $data);
                    $this->load->view('templates/user_footer');


                    if (isset($_POST['check1'])) {
                        $email = $data['user']['email'];
                        $subject = "Checking Email";
                        $message  = "Salin kode berikut lalu tempelkan ke kolom current email code: <br/><br/> $code1";
                        $sendmail = array(
                            'recipient_email' => $email,
                            'subject' => $subject,
                            'content' => $message
                        );
                        $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                        echo "<script>
                                alert('Check your current email!')
                            </script>";
                    } elseif (isset($_POST['check2'])) {

                        $permitted_chars = '0123456789';
                        $code2 = substr(str_shuffle($permitted_chars), 0, 6);
                        $this->db->set('email_code', $code2);
                        $this->db->where('email', $data['user']['email']);
                        $this->db->update('user');

                        $email = $this->input->post('email2');
                        $subject = "Checking Email";
                        $message  = "Salin kode berikut lalu tempelkan ke kolom new email code: <br/><br/> $code2";
                        $sendmail = array(
                            'recipient_email' => $email,
                            'subject' => $subject,
                            'content' => $message
                        );

                        $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                        echo "<script>
                            alert('Check your new email!')
                        </script>";
                    }
                } else {
                    $current_email = $this->input->post('email');
                    $email2 = $this->input->post('email2');
                    $check_code1 = $this->input->post('check_code1');
                    $check_code2 = $this->input->post('check_code2');

                    if ($current_email != $data['user']['email']) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Current email is wrong</div>');
                        redirect('user/changeEmail');
                    } else {
                        if ($current_email == $email2) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New email cannot be same with current email</div>');
                            redirect('user/changeEmail');
                        } else {
                            if ($code1 == $check_code1) {
                                if ($data['user']['email_code'] == $check_code2) {
                                    $newemail = $email2;
                                    $id = $data['user']['id'];

                                    $this->db->set('email', $newemail);
                                    $this->db->where('id', $id);
                                    $this->db->update('user');

                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Email has been change. Please login!</div>');
                                    redirect('auth');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New email code is wrong!</div>');
                                    redirect('user/changeEmail');
                                }
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Current email code is wrong!</div>');
                                redirect('user/changeEmail');
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function changePassword()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);


        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {

                $this->form_validation->set_rules('password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('password1', 'New Password', 'trim|required|min_length[3]|matches[password2]');
                $this->form_validation->set_rules('password2', 'Repeat New Password', 'trim|required|min_length[3]|matches[password1]');
                $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');

                if ($this->form_validation->run() == false) {
                    $data['title'] = 'Change Password';
                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/setting/change_password', $data);
                    $this->load->view('templates/user_footer');

                    if (isset($_POST['check'])) {
                        $email = $data['user']['email'];

                        $permitted_chars = '0123456789';
                        $code = substr(str_shuffle($permitted_chars), 0, 6);
                        $this->db->set('email_code', $code);
                        $this->db->where('email', $email);
                        $this->db->update('user');

                        $subject = "Checking Email";
                        $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                        $sendmail = array(
                            'recipient_email' => $email,
                            'subject' => $subject,
                            'content' => $message
                        );
                        $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                        echo "<script>
                                alert('Check your email!')
                            </script>";
                    }
                } else {
                    $current_password = $this->input->post('password');
                    $password1 = $this->input->post('password1');
                    $email_code = $this->input->post('email_code');

                    if (!password_verify($current_password, $data['user']['password'])) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Current password is wrong!</div>');
                        redirect('user/changePassword');
                    } else {
                        if ($current_password == $password1) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New password cannot be same with current password</div>');
                            redirect('user/changePassword');
                        } else {
                            if ($data['user']['email_code'] == $email_code) {
                                $password = password_hash($password1, PASSWORD_DEFAULT);
                                $email = $data['user']['email'];

                                $this->db->set('password', $password);
                                $this->db->where('email', $email);
                                $this->db->update('user');

                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been change. Please login!</div>');
                                redirect('auth');
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Email code is wrong!</div>');
                                redirect('user/changePassword');
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function google_otp()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Google OTP';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {

            $email = $data['user']['email'];
            $user_secret = $data['user']['secret_otp'];


            $ga = new GoogleAuthenticator();
            $secret = $ga->createSecret();

            $this->form_validation->set_rules('code', 'OTP Code', 'trim|required');

            if ($user_secret == '') {
                $data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($data['user']['username'], $secret, 'zenith-filecoin');
                $this->db->set('secret_otp', $secret);
                $this->db->where('email', $email);
                $this->db->update('user');
            } else {
                $data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($data['user']['username'], $user_secret, 'zenith-filecoin');
                if (isset($_POST['submit'])) {
                    $code = $this->input->post('code');
                    $checkResult = $ga->verifyCode($user_secret, $code);
                    if ($checkResult) {
                        $this->db->set('is_otp', 1);
                        $this->db->where('email', $email);
                        $this->db->update('user');
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">OTP created successfully</div>');
                        redirect('user/google_otp');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Wrong OTP code</div>');
                    }
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">OTP disabled successfully</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Wrong OTP Code</div>');
                    redirect('user/google_otp');
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">OTP disabled successfully</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Wrong OTP Code</div>');
                    redirect('user/google_otp');
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">OTP disabled successfully</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Wrong OTP Code</div>');
                    redirect('user/google_otp');
                }
            }

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/setting/google_otp', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function customer_service()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Customer Service';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_data_home($query_user['id'])->row_array();
        $data['get_uniq']           = $this->M_user->getUniqMessage($query_user['email'])->row_array();
        $data['message']            = $this->M_user->get_message($query_user['email'], $data['get_uniq']['uniq_id'] ?? null)->result();
        $data['message_robot']      = $this->M_user->get_message_robot($query_user['email'])->result();
        // $data['get_user']           = $this->M_user->get_user_by($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            if (empty($_FILES['image']['name'])) {
                if (isset($_POST['submit'])) {
                    $message = $this->input->post('message');
                    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                    $uniq = substr(str_shuffle($permitted_chars), 0, 6);
                    if ($data['get_uniq'] == NULL) {
                        $uniq_id = $uniq;
                    } else {
                        $uniq_id = $data['get_uniq']['uniq_id'];
                    }
                    $data = [
                        'uniq_id' => $uniq_id,
                        'name' => $data['user']['first_name'],
                        'sender_email' => $data['user']['email'],
                        'email' => $data['user']['email'],
                        'phone' => $data['user']['phone'],
                        'message' => $message,
                        'time' => time()
                    ];
                    $insert = $this->M_user->insert_data('user_messages', $data);
                    if ($insert == true) {
                        redirect('user/customer_service');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Send message failed</div>');
                        redirect('user/customer_service');
                    }
                }
            } else {
                if (isset($_POST['submit'])) { // Jika user menekan tombol Submit (Simpan) pada form
                    // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
                    $upload = $this->M_user->upload_photo_message();

                    if ($upload['result'] == "success") { // Jika proses upload sukses
                        // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                        $data = array(
                            'uniq_id' => $data['get_uniq']['uniq_id'],
                            'name' => $data['get_uniq']['name'],
                            'sender_email' => $data['get_uniq']['sender_email'],
                            'email' => $data['get_uniq']['email'],
                            'phone' => $data['get_uniq']['phone'],
                            'message' => '',
                            'image' => $upload['file']['file_name'],
                            'time' => time()
                        );
                        $this->db->insert('user_messages', $data);

                        redirect('user/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success</div>');
                    } else { // Jika proses upload gagal
                        redirect('user/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Error</div>');
                    }
                }
            }

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/customer_service', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function miningGenerasi()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_mingeneration_byid($query_user['id']);


        $data['title']              = 'Mining Generasi';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_miningpairing($query_user['id'])->get()->result();
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['amount'];


        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/mining_pairing', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        }
    }

    public function withdrawal_fil()
    {
        if (!empty($this->uri->segment(3))) {
            $id_notif = $this->uri->segment(3);

            //update notification
            $data_notif = [
                'is_show' => 1
            ];

            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $id_notif);
        }

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();

        $data['title']              = 'Withdrawal';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['fill'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|callback_checkfirstchar');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            $this->form_validation->set_rules('total', 'Total', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/withdrawal_fil', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/withdrawal_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/withdrawal_fil');
                    } else {
                        if ($amount > $data['general_balance_fil']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough filecoins</div>');
                            redirect('user/withdrawal_fil');
                        } else {
                            if ($amount < $query_minimum_withdrawal['filecoin']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Minimum amount for withdrawal is ' . $query_minimum_withdrawal['filecoin'] . ' FIL</div>');
                                redirect('user/withdrawal_fil');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                    redirect('user/withdrawal_fil');
                                } else {
                                    $withdrawal = [
                                        'user_id' => $user_id,
                                        'coin_type' => 'filecoin',
                                        'wallet_address' => $wallet,
                                        'amount' => $amount,
                                        'total' => $total,
                                        'datecreate' => time(),
                                    ];
                                    $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                    if ($insert == true) {
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request Withdrawal Success</div>');
                                        redirect('user/withdrawal_fil');
                                    } else {
                                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Request Withdrawal Failed</div>');
                                        redirect('user/withdrawal_fil');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function bonusBasecamp()
    {
        $this->_unset_payment();
        $date = date('Y-m-d');
        $month = date('m');

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_basecamp_byid($query_user['id']);


        $basecamp = $query_user['basecamp'] ?? null;

        $data['title']              = 'Bonus Basecamp';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_basecamp($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['userClass']          = $this;
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['today_omset']        = $this->M_user->get_today_purchase_basecamp($date, $basecamp);
        $data['total_omset']        = $this->M_user->get_current_purchase_basecamp($month, $basecamp);
        $data['total']              = $query_total['zenx'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/basecamp', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function withdrawal_mtm()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_mtm         = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();

        $data['title']              = 'Withdrawal';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['mtm'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            $this->form_validation->set_rules('total', 'Total', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/withdrawal_mtm', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/withdrawal_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/withdrawal_mtm');
                    } else {
                        if ($amount > $data['general_balance_mtm']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                            redirect('user/withdrawal_mtm');
                        } else {
                            if ($amount < $query_minimum_withdrawal['mtm']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Minimum amount for withdrawal is ' . $query_minimum_withdrawal['mtm'] . ' MTM</div>');
                                redirect('user/withdrawal_mtm');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                    redirect('user/withdrawal_mtm');
                                } else {
                                    $withdrawal = [
                                        'user_id' => $user_id,
                                        'coin_type' => 'mtm',
                                        'wallet_address' => $wallet,
                                        'amount' => $amount,
                                        'total' => $total,
                                        'datecreate' => time(),
                                    ];
                                    $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                    if ($insert == true) {
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request Withdrawal Success</div>');
                                        redirect('user/withdrawal_mtm');
                                    } else {
                                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Request Withdrawal Failed</div>');
                                        redirect('user/withdrawal_mtm');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }
    
    public function withdrawal_zenx()
    {
        if (!empty($this->uri->segment(3))) {
            $id_notif = $this->uri->segment(3);

            //update notification
            $data_notif = [
                'is_show' => 1
            ];

            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $id_notif);
        }

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_zenx        = $this->M_user->get_total_byuser('airdrop_zenx_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_zenx  = $this->M_user->get_transfer_bonus($query_user['id'], 'zenx');
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'zenx');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']              = 'Withdrawal';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['deposit']            = $this->M_user->get_deposit_general($query_user['id'], '3');
        $data['general']            = $query_transfer_bonus_zenx['amount'] + $query_transfer_zenx['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['zenx'] - $query_total_withdrawal['amount'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|callback_checkfirstcharz');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required');
            $this->form_validation->set_rules('total', 'Total', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/zenx/withdrawal_zenx', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/withdrawal_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/withdrawal_zenx');
                    } else {
                        if ($amount > $data['general']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                            redirect('user/withdrawal_zenx');
                        } else {
                            if ($amount < $query_minimum_withdrawal['zenx']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Minimum amount for withdrawal is ' . $query_minimum_withdrawal['zenx'] . ' ZENX</div>');
                                redirect('user/withdrawal_zenx');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                    redirect('user/withdrawal_zenx');
                                } else {
                                    $withdrawal = [
                                        'user_id' => $user_id,
                                        'coin_type' => 'zenx',
                                        'wallet_address' => $wallet,
                                        'amount' => $amount,
                                        'total' => $total,
                                        'datecreate' => time(),
                                    ];
                                    $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                    if ($insert == true) {
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request Withdrawal Success</div>');
                                        redirect('user/withdrawal_zenx');
                                    } else {
                                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Request Withdrawal Failed</div>');
                                        redirect('user/withdrawal_zenx');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function checkfirstchar($text)
    {
        $first_ch = substr($text,0,1);
        $count = strlen($text);

        if ($first_ch=='f' && $count == 41)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('checkfirstchar','Wallet address must Filecoin wallet');
            return FALSE;
        }
    }

    public function checkfirstcharz($text)
    {
        $first_ch = substr($text,0,1);
        $count = strlen($text);

        if ($first_ch=='0' && $count == 42)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('checkfirstcharz','Wallet address must Zenx wallet');
            return FALSE;
        }
    }

    public function transfer_mining_fil()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = 'Transfer to General';
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/transfer_mining_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_mining_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_mining_fil');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough filecoins</div>');
                            redirect('user/transfer_mining_fil');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_mining_fil');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('mining_user_transfer', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_mining_fil');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_mining_fil');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function usernameBasecamp($id)
    {
        $query = $this->M_user->get_username_basecamp($id);

        return $query['username'];
    }


    public function transfer_airdrops_mtm()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = 'Transfer to General';
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/transfer_airdrops_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_airdrops_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_airdrops_mtm');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough MTM</div>');
                            redirect('user/transfer_airdrops_mtm');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_airdrops_mtm');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('airdrop_mtm_transfer', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_airdrops_mtm');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_airdrops_mtm');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_airdrops_zenx()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('airdrop_zenx', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('airdrop_zenx_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = 'Transfer to General';
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/zenx/transfer_airdrops_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_airdrops_zenx');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_airdrops_zenx');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough ZENX</div>');
                            redirect('user/transfer_airdrops_zenx');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_airdrops_zenx');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('airdrop_zenx_transfer', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_airdrops_zenx');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_airdrops_zenx');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_fil()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');

        $data['title']              = 'Transfer to General';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_fil']          = $query_total['sponsorfil'] + $query_total['sponmatchingfil'] + $query_total['minmatching'] + $query_total['minpairing'];
        $data['balance']            = $data['total_fil'] - $query_transfer_bonus_fill['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/transfer_bonus_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_bonus_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_bonus_fil');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough filecoins</div>');
                            redirect('user/transfer_bonus_fil');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_bonus_fil');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'coin_type' => 'filecoin',
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('bonus_transfer_general', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_bonus_fil');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_bonus_fil');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_mtm()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');

        $data['title']              = 'Transfer to General';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_mtm']          = $query_total['sponsormtm'] + $query_total['sponmatchingmtm'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampmtm'];
        $data['balance']            = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/transfer_bonus_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_bonus_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_bonus_mtm');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough MTM</div>');
                            redirect('user/transfer_bonus_mtm');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_bonus_mtm');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'coin_type' => 'mtm',
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('bonus_transfer_general', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_bonus_mtm');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_bonus_mtm');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_zenx()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_zenx  = $this->M_user->get_transfer_bonus($query_user['id'], 'zenx');

        $data['title']              = 'Transfer to General';
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_zenx']         = $query_total['sponsorzenx'] + $query_total['sponmatchingzenx'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampzenx'];
        $data['balance']            = $data['total_zenx'] - $query_transfer_bonus_zenx['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required');
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/zenx/transfer_bonus_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "Checking Email";
                    $message  = "Salin kode berikut lalu tempelkan ke kolom email code: <br/><br/> $code";
                    $sendmail = array(
                        'recipient_email' => $email,
                        'subject' => $subject,
                        'content' => $message
                    );
                    $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                    echo "<script>
                            alert('Check your email!')
                        </script>";
                }
            } else {
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You need to register the OTP. Go to Setting > Goggle OTP</div>');
                    redirect('user/transfer_bonus_zenx');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email code is wrong</div>');
                        redirect('user/transfer_bonus_zenx');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Not enough ZENX</div>');
                            redirect('user/transfer_bonus_zenx');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">OTP code is wrong</div>');
                                redirect('user/transfer_bonus_zenx');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'coin_type' => 'zenx',
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('bonus_transfer_general', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully transferred to general</div>');
                                    redirect('user/transfer_bonus_zenx');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed to transfer to general</div>');
                                    redirect('user/transfer_bonus_zenx');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function filDeposit()
    {
        $user  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //Validation Proses
        $this->form_validation->set_rules('txid', 'TXID', 'required|trim');
        $this->form_validation->set_rules('fil', 'Coin quantity', 'required');

        if ($this->form_validation->run() == false) //check validation
        {
        }
        //echo $user['id'];
    }
    
    public function news_announcement()
    {
        $this->_unset_payment();
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        if ($query_user['is_news'] == 0) {
            $data_news = [
                'is_news' => 1
            ];
            $update_news = $this->M_user->update_data_byid('user', $data_news, 'id', $query_user['id']);
        }

        $data['title']              = 'News';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['userClass']          = $this;
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['news']               = $this->M_user->get_all_news()->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/news_announcement', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    //count limit level
    public function _countLimitLevel($endLoop, $user_id)
    {
        $query_position = $this->M_user->get_network_byposition($user_id);

        if (count($query_position) != '') 
        {
            foreach ($query_position as $row_position) 
            {
                return $this->_countLimitLevel($endLoop+1, $row_position->user_id);
            }
        }
        else
        {
            return $endLoop;
        }
    }
}
