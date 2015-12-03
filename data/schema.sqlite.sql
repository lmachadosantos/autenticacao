CREATE TABLE usuario (
	id INTEGER PRIMARY KEY,
	login VARCHAR(255) UNIQUE NOT NULL,
	senha VARCHAR(32) NOT NULL,
	criado_em DATE NOT NULL,
	atualizado_em DATE,
	ativo BOOLEAN DEFAULT FALSE
);

CREATE TABLE perfil (
	id INTEGER PRIMARY KEY,
	usuario_id INTEGER NOT NULL,
	titulo VARCHAR(120) NOT NULL,
	descricao VARCHAR(255) NOT NULL,
	criado_em DATE NOT NULL,
	atualizado_em DATE,
	ativo BOOLEAN DEFAULT FALSE,
	FOREIGN KEY(usuario_id) REFERENCES usuario(id)
);

CREATE TABLE papel (
	id INTEGER PRIMARY KEY,
	perfil_id INTEGER NOT NULL,
	titulo VARCHAR(120) NOT NULL,
	descricao VARCHAR(255) NOT NULL,
	criado_em DATE NOT NULL,
	atualizado_em DATE,
	ativo BOOLEAN DEFAULT FALSE,
	FOREIGN KEY(perfil_id) REFERENCES perfil(id)
);

CREATE TABLE recurso (
	id INTEGER PRIMARY KEY,
	papel_id INTEGER NOT NULL,
	recurso VARCHAR(255) NOT NULL,
	recurso_url VARCHAR(255) NOT NULL,
	criado_em DATE NOT NULL,
	atualizado_em DATE,
	ativo BOOLEAN DEFAULT FALSE,
	FOREIGN KEY(papel_id) REFERENCES papel(id)
);
