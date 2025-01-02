export function handleError(axiosError: any) {
  let errors: any = {};

  if (axiosError.response.status == 401) {
    errors.general = 'Identification incorrect ou droits insuffisants';
  }
  else if (axiosError.response.status == 422) {
    errors = axiosError.response.data.errors;
  }

  return errors;
}