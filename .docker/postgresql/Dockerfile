# Use the official PostgreSQL image
FROM postgres:16

# Copy the custom pg_hba.conf file into the container
# COPY pg_hba.conf /etc/postgresql/pg_hba.conf
ENV POSTGRES_HOST_AUTH_METHOD md5

# Set environment variables (optional)
ENV POSTGRES_DB=postgres \
    POSTGRES_USER=postgres \
    POSTGRES_PASSWORD=postgres

# Expose PostgreSQL default port
EXPOSE 5432

# Start PostgreSQL service
# CMD ["postgres", "-c", "config_file=/etc/postgresql/pg_hba.conf"]
CMD ["postgres"]
