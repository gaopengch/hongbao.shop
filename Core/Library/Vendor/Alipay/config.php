<?php
$config = array (
		//应用ID,您的APPID。
		'app_id' => "2016101200669801",

		//商户私钥
		'merchant_private_key' => "MIICXAIBAAKBgQDJ6L9VlC8BqNDqXKYwkGx5yf4/pHYggdKl8bVc0fEs01aOYjaVhLsNmouBoiy++f0/taiA2X4jw2t4qRS3NdY+W57S/QtBKu9cEtmg1FbB2FOAXHQJrD7DOJdiQNi9uSLdSYN+XSqJ7RkSGDed0AIKuPodOoXbC7enD1CLzcP81QIDAQABAoGBALFIs/eojT2fxRCDGUk7BoRJX/zxoucYFqWufdhqXqFFT5LlmZffW36uXCAPDcsCJeNy1emNDrzIMe1YSOA1XU8EBSzJ/8Eaj1bRNmBqV3Lbje/eWrMxbIyQMb5+wPhX0u8pOa7l9LnfMFXZ+463AJmuRyULeAM0UWKNC/pVPKEBAkEA7GK6wulz7Gk3KGkjUmrBb5XsQwHHZzKqtrs3DVKZoUw+iMx23m8y0ExmwWGvNhFzWMdJYA9YrC04FFyqi9aduQJBANqprFJHDQLxsQgiU7iyG98TA+eStdAHKFv/6DfnabQ0+WHmJmyr5RmNDBk5DCpVBhDvgwQ5KGHMUODDzOUBhf0CQG0iU9lDENsX5HhKuh0F3pKW5AI3owkZEknU+2CyPu2CFujvhP3C1vHmJBap88uBmQBm2ZB45VZwdhCoi7COADkCQC0tCPEmxMVq8cxgazOpeKCp6RCa+v0zvV7kjDGgmfIlT7CuQBoLmZWh0nITmzPTxSESmtrwhCtQbxVA3sAhhHECQGWUJAJHwmQbImtV9mQp+UihHN7hkNFVEzGiyaffhq7eiyHeo1u0HM3Eiu1x1ZrsjkoaAJc1jZgTTxIFv4z1b88=",
		
		//异步通知地址
//		'notify_url' => "http://wkvfs4.natappfree.cc/alipay/notify_url.php",
//
//		//同步跳转
//		'return_url' => "http://wkvfs4.natappfree.cc/alipay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA",

		//支付宝网关
//		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB",
);