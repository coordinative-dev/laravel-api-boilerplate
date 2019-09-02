FROM postgres:11.2

ARG HOST_UID=1000

RUN usermod -u ${HOST_UID} postgres
RUN groupmod -g ${HOST_UID} postgres

EXPOSE 5432
