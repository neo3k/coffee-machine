## Architecture and dev-ops

###### 1 - Suddenly, our monitoring systems have started reporting low disk space in our ElasticSearch clusters! I knew it! These hipster databases can never be any good! And now /var/log/elasticsearch is growing like if there was no tomorrow! What can we do about it?

`cat /dev/null > /var/log/elasticsearch/production.log
`
###### 2 - Somehow, the application starts returning HTTP 500 errors. We have a very poor logging system so the only option is to SSH into the web servers and when we tail the logs, we find lots of errors trying to connect to the database. How would you check the network is working correctly and you can contact a MySQL server called 'deliverea-rds-master' which should be listening on the default MySQL port?-> nc -zv deliverea-rds-master 3306

Option A:
`mysql -h deliverea-rds-master -u root -p`

Option B:
`netstat -tlpn | grep mysql`
###### 3 - There seems to be a problem in our EC2 instance. We have been able to SSH but the website is still blank. How can we know if Apache / Nginx is running?

OS: Ubuntu

Option A:
`ps -ef | grep nginx`

Option B:
`systemctl status nginx`

###### 4 - Ansible stopped working and we had to SSH some production servers and manually edit some files. Only VIM is available there! The horror! We have applied our changes but how do we save the file and exit VIM?

1. Press Escape Key
2. Type: `:wq`

###### 5 - The Operations guys are performing maintenance tasks in the MySQL Cluster and we need to put the website in maintenance mode. But Google keeps indexing the maintenance page and this is affecting our SEO. How can we avoid this situation?

`noindex` in robots.txt (maintenance file URI)


###### 6 - A DevOps Engineer in the team keeps saying we need to start applying IAM roles to our EC2 instances in AWS. Do you know what this is and what can it be used for?

The IAM roles grant permissions to instances. For example, to access a Bucket S3.

###### 7 - We just had a security audit and we were told we need to change our AWS setup so that we use a Bastion to access our Production servers. Can you describe what this is and why it improves security?

A bastion is a server with the purpose of being the first entry point of the network, acting as a proxy with the rest of EC2 instances.
It is useful when the number of instances is high enough or for autoscaling.

###### 8 - Briefly comment if you have had expirience working, even partially, as a dev-ops in the past (tasks, responsabilities, certificates...).

In my company we have large accounts (public, private institutions) in which I am the DevOps of the project.

- European Institute of Innovation & Technology: Nutrify
  
- Cabildo de Tenerife: Plataforma oficial de empleo de Tenerife
  
- Metropolitano de Tenerife: Plataforma de solicitud de bono de transporte de Tenerife
  
- Mutua Tinerfeña: Intranet