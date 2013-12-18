wget http://apt.typesafe.com/repo-deb-build-0002.deb
sudo dpkg -i repo-deb-build-0002.deb
sudo apt-get update
sudo apt-get install sbt
rm -f repo-deb-build-0002.deb
wget  http://typesafe.artifactoryonline.com/typesafe/ivy-releases/org.scala-sbt/sbt-launch/0.13.0/sbt-launch.jar
mkdir -p /home/brad/.sbt/.lib/0.13.0/
mv sbt-launch.jar /home/brad/.sbt/.lib/0.13.0/sbt-launch.jar
rm sbt-launch.jar
sudo apt-get install openjdk-7-jdk
