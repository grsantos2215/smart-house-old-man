<?php

class InterfaceArduino
{
	private $porta;
	public $statusPorta = "false";
	private $baud;
	private $parity;
	private $data;
	private $stop;
	private $xon;
	private $fp;

	public function __construct()
	{
		$this->setAtributos(null, null, null, null, null, null);
	}

	public function setAtributos($porta, $baud, $parity, $data, $stop, $xon)
	{
		$this->porta = $porta;
		$this->baud = $baud;
		$this->parity = $parity;
		$this->data = $data;
		$this->stop = $stop;
		$this->xon = $xon;
	}

	public function getPorta()
	{
		return $this->porta;
	}

	public function getStatusPorta()
	{
		return $this->statusPorta;
	}

	public function openCOM()
	{

		exec("mode " . $this->porta . " BAUD = " . $this->baud . " PARITY = " . $this->parity . "data = " . $this->data . " stop = " . $this->stop . " xon = " . $this->xon);

		if ($this->fp = fopen($this->porta, "w+")) {
			$this->statusPorta = "true";
			return true;
		} else {
			$this->statusPorta = "false";
			return false;
		}
	}

	public function closeCOM()
	{
		if (fclose($this->fp)) {
			$this->statusPorta = "false";
			return true;
		} else {
			$this->statusPorta = "true";
			return false;
		}
	}

	public function writeCOM($valor)
	{
		sleep(2);
		if (fwrite($this->fp, $valor))
			return true;
		else
			return false;
	}

	public function readCOM()
	{
		sleep(2);
		$dados = "";
		while (!feof($this->fp)) {
			$dados .= fread($this->fp, 1);
		}
		return $dados;
	}
}
