<?php
//
// �������� ������
//
class M_Articles
{
	private static $instance; 	// ������ �� ��������� ������
	private $msql; 				// ������� ��
	
	//
	// ��������� ������������� ���������� (��������)
	//
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new M_Articles();
		
		return self::$instance;
	}
