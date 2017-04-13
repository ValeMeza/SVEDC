DROP TABLE IF EXISTS svedc;
DROP TABLE IF EXISTS checkins;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS ppc;
CREATE TABLE ppc(
  oAuthId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  oAuthServiceName VARCHAR(32) NOT NULL,
  PRIMARY KEY (oAuthId)
);
CREATE TABLE people(
  peopleDashboard INT UNSIGNED NOT NULL,
  peopleLists VARCHAR(80),
  peopleWorkflows INT UNSIGNED NOT NULL,
  peoplePeople VARCHAR(64) NOT NULL,
  INDEX(peopleWorkflows),
  FOREIGN KEY(peopleDashboard) REFERENCES ppc(oAuthId)
);
CREATE TABLE registrations(
  registrationsEvents INT UNSIGNED NOT NULL,
  registrationsPayments INT UNSIGNED AUTO_INCREMENT,
  registrationsPeople VARCHAR(64) NOT NULL,
  INDEX(registrationsPayments)
);
CREATE TABLE checkins(
  checkinsEvents INT UNSIGNED NOT NULL,
  checkinsStations INT UNSIGNED NOT NULL,
  checkinsPeople VARCHAR(64) NOT NULL,
  INDEX(checkinsEvents)
);
CREATE TABLE svedc (
  svedcCalander INT UNSIGNED AUTO_INCREMENT NOT NULL,
  svedcDate DATE,
  svedcTitle VARCHAR(42),
  svedcDetails VARCHAR(82),
  svedcUrl VARCHAR(64),
  UNIQUE(svedcUrl),
  INDEX(svedcCalander)
)
