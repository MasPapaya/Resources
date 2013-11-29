-- -----------------------------------------------------
-- Require: entities
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Drops
-- -----------------------------------------------------

DROP TABLE IF EXISTS resources;
DROP TABLE IF EXISTS allowed_types;
DROP TABLE IF EXISTS allowed_resource_types;
DROP TABLE IF EXISTS resource_types;
DROP TABLE IF EXISTS resource_group_types;


-- -----------------------------------------------------
-- Table resource_group_types
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS resource_group_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  entity_id INT UNSIGNED NOT NULL,
  is_single TINYINT(1) NOT NULL,
  name VARCHAR(45) NOT NULL,
  alias VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

ALTER TABLE resource_group_types ADD INDEX resgrotyp_ent_idx (entity_id ASC);


-- -----------------------------------------------------
-- Table resource_types
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS resource_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  alias VARCHAR(45) NOT NULL,
  extensions VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table allowed_resource_types
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS allowed_resource_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  resource_type_id INT UNSIGNED NOT NULL,
  resource_group_type_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

ALTER TABLE allowed_resource_types ADD INDEX allrestyp_restyp_idx (resource_type_id ASC);
ALTER TABLE allowed_resource_types ADD INDEX allrestyp_resgrotyp_idx (resource_group_type_id ASC);


-- -----------------------------------------------------
-- Table allowed_types
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS allowed_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  resource_type_id INT UNSIGNED NOT NULL,
  mimetype VARCHAR(120) NOT NULL,
  extension VARCHAR(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

ALTER TABLE allowed_types ADD INDEX alltyp_restyp_idx (resource_type_id ASC);


-- -----------------------------------------------------
-- Table resources
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS resources (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  resource_type_id INT UNSIGNED NOT NULL,
  resource_group_type_id INT UNSIGNED NOT NULL,
  parent_entityid INT UNSIGNED NOT NULL,
  ordering INT UNSIGNED NOT NULL,
  created DATETIME NOT NULL,
  deleted DATETIME NOT NULL,
  banned DATETIME NOT NULL,
  name VARCHAR(45) NOT NULL,
  filename VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

ALTER TABLE resources ADD INDEX res_restyp_idx (resource_type_id ASC);
ALTER TABLE resources ADD INDEX res_resgrotyp_idx (resource_group_type_id ASC);


-- -----------------------------------------------------
-- Constraints
-- -----------------------------------------------------

ALTER TABLE resource_group_types ADD
CONSTRAINT resgrotyp_ent_fk FOREIGN KEY (entity_id) REFERENCES entities (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE allowed_resource_types ADD
CONSTRAINT allrestyp_restyp_fk FOREIGN KEY (resource_type_id) REFERENCES resource_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE allowed_resource_types ADD
CONSTRAINT allrestyp_resgrotyp_fk FOREIGN KEY (resource_group_type_id) REFERENCES resource_group_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE allowed_types ADD
CONSTRAINT alltyp_restyp_fk FOREIGN KEY (resource_type_id) REFERENCES resource_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE resources ADD
CONSTRAINT res_restyp_fk FOREIGN KEY (resource_type_id) REFERENCES resource_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE resources ADD
CONSTRAINT res_resgrotyp_fk FOREIGN KEY (resource_group_type_id) REFERENCES resource_group_types (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;


-- -----------------------------------------------------
-- View view_resources
-- -----------------------------------------------------

CREATE  OR REPLACE VIEW view_resources AS
SELECT Resource.id AS id,
Resource.resource_type_id AS type_id,
ResourceGroupType.id AS group_type_id,
Entity.id AS entity_id,
Resource.parent_entityid AS parent_entityid,
Resource.ordering AS ordering,
ResourceGroupType.name AS group_type_name,
ResourceGroupType.alias AS group_type_alias,
ResourceGroupType.is_single AS is_single,
Resource.filename AS filename,
Resource.created AS created,
Resource.deleted AS deleted,
Resource.name AS name,
ResourceType.name AS type_name,
Entity.name AS entity_name,
Entity.folder AS entity_folder,
Entity.alias AS entity_alias
FROM resources Resource
LEFT JOIN resource_group_types ResourceGroupType on ResourceGroupType.id = Resource.resource_group_type_id
LEFT JOIN allowed_resource_types AllowedResourceType on AllowedResourceType.resource_group_type_id = ResourceGroupType.id
LEFT JOIN resource_types ResourceType on AllowedResourceType.resource_type_id = ResourceType.id
LEFT JOIN entities Entity on ResourceGroupType.entity_id = Entity.id
WHERE ResourceType.id = Resource.resource_type_id;


-- -----------------------------------------------------
-- View view_resource_groups
-- -----------------------------------------------------

CREATE OR REPLACE VIEW view_resource_groups AS
SELECT
Resource.id AS id,
Resource.name AS resource_name,
Resource.filename AS resource_filename,
ResourceGroupType.entity_id AS entity_id,
Resource.parent_entityid AS parent_entityid,
ResourceGroupType.id AS group_type_id,
ResourceGroupType.name AS group_type_name,
ResourceGroupType.is_single AS group_type_is_single,
Resource.resource_type_id AS type_id,
ResourceType.name AS type_name,
Resource.ordering AS ordering
FROM resources Resource
LEFT JOIN resource_types ResourceType ON Resource.resource_type_id = ResourceType.id
LEFT JOIN resource_group_types ResourceGroupType ON ResourceGroupType.id = Resource.resource_group_type_id
WHERE Resource.deleted = '0000-00-00 00:00:00'
AND Resource.banned = '0000-00-00 00:00:00';


-- -----------------------------------------------------
-- View view_resource_settings
-- -----------------------------------------------------

CREATE  OR REPLACE VIEW 
view_resource_settings AS 
SELECT
AllowedResourceType.id AS id,
Entity.id AS entity_id,
Entity.name AS entity_name,
Entity.alias AS entity_alias,
Entity.folder AS entity_folder,
ResourceGroupType.id AS resource_group_type_id,
ResourceGroupType.alias AS resource_group_type_alias,
ResourceGroupType.name AS resource_group_type_name,
ResourceGroupType.is_single AS resource_group_type_is_single,
ResourceType.id AS resource_type_id,
ResourceType.alias AS resource_type_alias,
ResourceType.name AS resource_type_name,
ResourceType.extensions AS extensions 
FROM allowed_resource_types AllowedResourceType
LEFT JOIN resource_types ResourceType ON ResourceType.id = AllowedResourceType.resource_type_id
LEFT JOIN resource_group_types ResourceGroupType ON ResourceGroupType.id = AllowedResourceType.resource_group_type_id
LEFT JOIN entities Entity ON Entity.id = ResourceGroupType.entity_id;


-- -----------------------------------------------------
-- View view_allowed_mimetypes
-- -----------------------------------------------------

CREATE  OR REPLACE VIEW 
view_allowed_mimetypes AS 
SELECT
ResourceGroupType.id AS id,
ResourceType.id AS resource_type_id,
AllowedType.mimetype AS mimetype 
FROM allowed_resource_types AllowedResourceType
LEFT JOIN resource_types ResourceType ON ResourceType.id = AllowedResourceType.resource_type_id
LEFT JOIN allowed_types AllowedType ON AllowedType.resource_type_id = ResourceType.id
LEFT JOIN resource_group_types ResourceGroupType ON ResourceGroupType.id = AllowedResourceType.resource_group_type_id
LEFT JOIN entities Entity ON Entity.id = ResourceGroupType.entity_id;
