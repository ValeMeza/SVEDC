DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS checkins;
DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS ppc;
DROP TABLE IF EXISTS svedc;
CREATE TABLE svedc (
  svedcCalander INT UNSIGNED AUTO_INCREMENT NOT NULL,
  INDEX(svedcCalander)
);
CREATE TABLE ppc(
  oAuthId INT UNSIGNED AUTO_INCREMENT NOT NULL,
  oAuthServiceName VARCHAR(32) NOT NULL,
  PRIMARY KEY (oAuthId)
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
CREATE TABLE people(
  peopleDashboard INT UNSIGNED NOT NULL,
  peopleLists INT AUTO_INCREMENT,
  peopleWorkflows INT UNSIGNED NOT NULL,
  peoplePeople VARCHAR(64) NOT NULL,
  INDEX(peopleWorkflows)
)

