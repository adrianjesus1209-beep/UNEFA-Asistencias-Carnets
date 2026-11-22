import { Redirect } from 'expo-router';

/**
 * Redireccion inicial de la aplicacion hacia la pantalla principal.
 */
export default function IndexScreen() {
  return <Redirect href="/landing" />;
}
