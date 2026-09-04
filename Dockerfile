###############################################################################
#   Copyright (C) 2024-2026 Shane aka, ShaYmez <shane@freestar.network>
#   Version 2.1.1
###############################################################################

FROM python:3.12-alpine3.21

RUN adduser -D -u 54000 radio

WORKDIR /hbmon

# Install build dependencies
RUN apk add --no-cache git gcc musl-dev libffi-dev openssl-dev cargo pkgconfig

# Copy only requirements first for better layer caching
COPY requirements.txt .

RUN pip install --upgrade pip \
    && pip install --no-cache-dir -r requirements.txt

# Remove build dependencies
RUN apk del git gcc musl-dev libffi-dev openssl-dev cargo pkgconfig

# Copy the application code
COPY . .

RUN chown -R radio /hbmon

COPY entrypoint /entrypoint
RUN chmod +x /entrypoint

USER radio

ENTRYPOINT ["/entrypoint"]
