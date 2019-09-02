FROM redis:5.0.5

ARG HOST_UID=1000

RUN usermod -u ${HOST_UID} redis
RUN groupmod -g ${HOST_UID} redis
