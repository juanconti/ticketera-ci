<?php
$config = array(
	'usuarios_alta' => array(
		[
			'field' => 'username',
			'label' => 'username',
			'rules' => 'trim|required|min_length[4]|max_length[15]|is_unique[usuarios.username]'
		],
		[
			'field' => 'sector',
			'label' => 'Sector',
			'rules' => 'trim|required|numeric|greater_than[1]'
		],
		[
			'field' => 'password',
			'label' => 'contraseña',
			'rules' => 'trim|required|regex_match[/^[0-9a-zA-ZñÑ\s]*$/]|min_length[5]|max_length[25]'
		],
		[
			'field' => 'passwordConfirma',
			'label' => 'confrirmacion de conrtaseña',
			'rules' => 'required|matches[password]'
		],
		[
			'field' => 'nombre',
			'label' => 'Nombre',
			'rules' => 'trim|max_length[25]'
		],
		[
			'field' => 'apellido',
			'label' => 'Apellido',
			'rules' => 'trim|max_length[25]'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|valid_email'
		],
		[
			'field' => 'estado',
			'label' => 'estado',
			'rules' => 'numeric|in_list[0,1]'
		]
	),
	'abonados_alta' => array(
		[
			'field' => 'descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required|min_length[4]|max_length[25]|is_unique[abonados.descripcion]'
		],
		[
			'field' => 'telefono',
			'label' => 'telefono',
			'rules' => 'trim|required|regex_match[/^[- +()]*[0-9][- +()0-9]*$/]|min_length[4]|max_length[50]'
		],
		[
			'field' => 'cuit',
			'label' => 'cuit',
			'rules' => 'trim|required|alpha_dash|min_length[5]|max_length[13]|is_unique[abonados.cuit]'
		],
		[
			'field' => 'razonSocial',
			'label' => 'razón social',
			'rules' => 'trim|required|min_length[5]|max_length[75]'
		],
		[
			'field' => 'email',
			'label' => 'email',
			'rules' => 'trim|max_length[50]|valid_email'
		],
		[
			'field' => 'estado',
			'label' => 'estado',
			'rules' => 'required|numeric|max_length[1]|in_list[0,1]'
		]
	),
	'abonados_edita' => array(
		[
			'field' => 'descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required|min_length[4]|max_length[25]'
		],
		[
			'field' => 'telefono',
			'label' => 'telefono',
			'rules' => 'trim|required|regex_match[/^[- +()]*[0-9][- +()0-9]*$/]|min_length[4]|max_length[50]'
		],
		[
			'field' => 'cuit',
			'label' => 'cuit',
			'rules' => 'trim|required|alpha_dash|min_length[5]|max_length[13]'
		],
		[
			'field' => 'razonSocial',
			'label' => 'razón social',
			'rules' => 'trim|required|min_length[5]|max_length[75]'
		],
		[
			'field' => 'email',
			'label' => 'email',
			'rules' => 'trim|max_length[50]|valid_email'
		],
		[
			'field' => 'estado',
			'label' => 'estado',
			'rules' => 'numeric|max_length[1]|in_list[0,1]'
		]
	),
	'tickets_alta' => array(
		[
			'field' => 'titulo',
			'label' => 'titulo',
			'rules' => 'trim|max_length[50]'
		],
		[
			'field' => 'cuerpo',
			'label' => 'cuerpo',
			'rules' => 'trim|required|min_length[10]|max_length[65535]'
		],
		[
			'field' => 'prioridad',
			'label' => 'prioridad',
			'rules' => 'trim|numeric|max_length[1]'
		],
		[
			'field' => 'abonado_id',
			'label' => 'abonado_id',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'estado',
			'label' => 'estado',
			'rules' => 'trim|required|numeric|greater_than[0]'
		]
	),
	'perfil_contraseña' => array(
		[
			'field' => 'oldClave',
			'label' => 'contraseña anterior',
			'rules' => 'trim|required|regex_match[/[a-zA-ZñÑ0-9]$/]|min_length[5]|max_length[25]'
		],
		[
			'field' => 'newClave',
			'label' => 'contraseña nueva',
			'rules' => 'trim|required|regex_match[/[a-zA-ZñÑ0-9]$/]|min_length[5]|max_length[25]'
		],
		[
			'field' => 'newClaveConfirma',
			'label' => 'confrirmacion de conrtaseña nueva',
			'rules' => 'required|matches[newClave]'
		]
	),
	'perfil_editar' => array(
		[
			'field' => 'nombre',
			'label' => 'Nombre',
			'rules' => 'trim|regex_match[/[a-zA-ZñÑ0-9.]$/]|max_length[25]'
		],
		[
			'field' => 'apellido',
			'label' => 'Apellido',
			'rules' => 'trim|regex_match[/[a-zA-ZñÑ0-9.]$/]|max_length[25]'
		],
		[
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|valid_email'
		]
	),
	'edita_sector' => array(
		[
			'field' => 'sector_id',
			'label' => 'id',
			'rules' => 'trim|required|numeric'
		],
		[
			'field' => 'sector_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required|regex_match[/[a-zA-ZñÑ0-9.]$/]|max_length[45]'
		],
		[
			'field' => 'sector_activo',
			'label' => 'activo',
			'rules' => 'trim|required|in_list[0,1]'
		],
		[
			'field' => 'sector_permisos[]',
			'label' => 'permisos',
			'rules' => 'trim|required|numeric|greater_than[1]'
		]
	),
	'alta_sector' => array(
		[
			'field' => 'sector_descripcion',
			'label' => 'descripcion',
			'rules' => 'trim|required|regex_match[/[a-zA-ZñÑ0-9.]$/]|max_length[45]'
		],
		[
			'field' => 'sector_activo',
			'label' => 'activo',
			'rules' => 'trim|required|in_list[0,1]'
		],
		[
			'field' => 'sector_permisos[]',
			'label' => 'permisos',
			'rules' => 'trim|required|numeric|greater_than[1]'
		]
	),
	'admin_perfil_contraseña' => array(
		[
			'field' => 'new-clave',
			'label' => 'contraseña nueva',
			'rules' => 'trim|required|regex_match[/[a-zA-ZñÑ0-9]$/]|min_length[5]|max_length[25]'
		],
		[
			'field' => 'new-clave-repetida',
			'label' => 'confrirmacion de conrtaseña nueva',
			'rules' => 'required|matches[new-clave]'
		]
	)
);