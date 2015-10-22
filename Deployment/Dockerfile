FROM linode/lamp

# Change default mysql user
RUN service mysql start && \
	mysqladmin -u root -pAdmin2015 password 6rXq5EDz7KJm46WY 

RUN service mysql stop

# Install postgres and change the default user's password
RUN apt-get update \
	&& apt-get -y install postgresql postgresql-contrib

RUN service postgresql start \
	&& sudo -u postgres psql -c"ALTER user postgres WITH PASSWORD '5kryRCnV85efXjWa'" \
	&& service postgresql restart


# Install Node JS
RUN apt-get -y install curl

ENV NPM_CONFIG_LOGLEVEL info
ENV NODE_VERSION 4.2.1

RUN curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.gz" \
	&& tar -xzf "node-v$NODE_VERSION-linux-x64.tar.gz" -C /usr/local --strip-components=1 \
	&& rm "node-v$NODE_VERSION-linux-x64.tar.gz"

RUN npm install -g forever

ADD . app

# Install dev tools

RUN apt-get -y install openssh-client git

RUN cd app \
	&& chmod 400 deployment \
	&& mkdir ~/.ssh  \
	&& cp deployment ~/.ssh/  \
	&& cp deployment.pub ~/.ssh/ \
	&& ls -a ~/.ssh \
	&& echo 'Host github.com \nHostname github.com \nIdentityFile ~/.ssh/deployment \nIdentitiesOnly yes' >> ~/.ssh/config && cat ~/.ssh/config

RUN cd ~ \
	&& git clone git@github.com:beakybal4/final-year-project.git

RUN cd app \
	&& npm install \
	&& node auto-deploy.js