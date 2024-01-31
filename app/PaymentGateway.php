<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
  protected $fillable = ['title', 'details', 'subtitle', 'name', 'type', 'information'];
  public $timestamps = false;

  //  This method decodes the 'information' attribute,
    // assumed to be in JSON format, into an associative array.
  public function convertAutoData()
  {
    return json_decode($this->information, true);
  }

  // this method Retrieves the last element of the array obtained from `convertAutoData()`.
  public function getAutoDataText()
  {
    $text = $this->convertAutoData();
    return end($text);
  }

  // this method Returns the 'keyword' attribute, or 'other' if it's null.
  public function showKeyword()
  {
    $data = $this->keyword == null ? 'other' : $this->keyword;
    return $data;
  }

  //this method Returns a checkout link based on the 'keyword' attribute.
  //The link is determined by checking the 'keyword' against known values ('paypal', 'stripe', etc.)
  //and constructing a route accordingly.
  public function showCheckoutLink()
  {
    $link = '';
    $data = $this->keyword == null ? 'other' : $this->keyword;
    if ($data == 'paypal') {
      $link = route('front.paypal.submit');
    } else if ($data == 'stripe') {
      $link = route('front.stripe.submit');
    } else if ($data == 'instamojo') {
      $link = route('front.instamojo.submit');
    } else if ($data == 'paytm') {
      $link = route('front.paytm.submit');
    } else if ($data == 'mollie') {
      $link = route('front.mollie.submit');
    } else if ($data == 'paystack') {
      $link = route('front.paystack.submit');
    } else if ($data == 'flutterwave') {
      $link = route('front.flutterwave.submit');
    } else if ($data == 'razorpay') {
      $link = route('front.razorpay.submit');
    } else if ($data == 'mercadopago') {
      $link = route('front.mercadopago.submit');
    } else if ($data == 'payumoney') {
      $link = route('front.payumoney.submit');
    }
    return $link;
  }

  //Determines whether to show a form based on the 'keyword'.
  //If the 'keyword' is in the array `$values` (containing only 'paypal' in this case),
  //the form should not be shown ('no'); otherwise, it should be shown ('yes').
  public function showForm()
  {
    $show = '';
    $data = $this->keyword == null ? 'other' : $this->keyword;
    $values = ['paypal'];
    if (in_array($data, $values)) {
      $show = 'no';
    } else {
      $show = 'yes';
    }
    return $show;
  }
}
/*
  <?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = ['title', 'details', 'subtitle', 'name', 'type', 'information'];
    public $timestamps = false;

    // Relations
    public function convertAutoData()
    {
        return json_decode($this->information, true);
    }

    public function getAutoDataText()
    {
        $text = $this->convertAutoData();
        return end($text);
    }

    public function showKeyword()
    {
        return $this->keyword ?? 'other';
    }

    public function showCheckoutLink()
    {
        $data = $this->showKeyword();

        $routeMap = [
            'paypal' => 'front.paypal.submit',
            'stripe' => 'front.stripe.submit',
            'instamojo' => 'front.instamojo.submit',
            'paytm' => 'front.paytm.submit',
            'mollie' => 'front.mollie.submit',
            'paystack' => 'front.paystack.submit',
            'flutterwave' => 'front.flutterwave.submit',
            'razorpay' => 'front.razorpay.submit',
            'mercadopago' => 'front.mercadopago.submit',
            'payumoney' => 'front.payumoney.submit',
        ];

        return $routeMap[$data] ?? '';
    }

    public function showForm()
    {
        $data = $this->showKeyword();
        $values = ['paypal'];

        return in_array($data, $values) ? 'no' : 'yes';
    }
}

*/
